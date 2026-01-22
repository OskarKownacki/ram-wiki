<?php

namespace App\Jobs;

use App\Models\HardwareTrait;
use App\Models\Ram;
use App\Models\Server;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProcessCsvImport implements ShouldQueue {
    use Batchable;
    use Queueable;

    public array $data;

    public array $rules;

    public array $optionalFields;

    public string $uniqueIndex;

    public string $modelName;

    public $fieldsToUpdate;

    public function __construct(array $data, array $rules, array $optionalFields, string $uniqueIndex, string $modelName) {
        $this->data = $data;
        $this->rules = $rules;
        $this->optionalFields = $optionalFields;
        $this->uniqueIndex = $uniqueIndex;
        $this->modelName = $modelName;
    }

    public function handle(): void {
        $validatedData = [];
        $mtmMap = [];
        foreach ($this->data as $data) {
            try {
                $validator = Validator::make($data, $this->rules);
                $validator->validate();
            } catch (ValidationException $e) {
                Log::error('CSV import vaildation failed for traits on trait:'.$data['name'].' with errors: '.json_encode($validator->errors()->all()));
                foreach ($validator->errors()->all() as $error) {
                    if (str_contains($error, 'required')) {
                        throw $e;
                    }
                }
                foreach ($this->optionalFields as $field) {
                    if ($validator->errors()->has($field)) {
                        $data[$field] = null;
                        Log::error('The field that didnt pass validation wasnt essential. It will be nulled, make sure to investigate the issue. Trait name: '.$data['name']);
                    }
                }
                $validator = Validator::make($data, $this->rules);
                $validator->validate();
            }

            $valid = $validator->validated();

            $validatedData[] = $valid;

            if ($this->modelName === 'Server' && ! empty($data['MtMValue'])) {
                $uniqueKeyValue = $valid[$this->uniqueIndex];
                $mtmMap[$uniqueKeyValue] = [
                    'values'    => $data['MtMValue'],
                    'delimiter' => $data['MtMDelimeter'] ?? ',',
                ];
            }

            if (empty($this->fieldsToUpdate)) {
                $this->fieldsToUpdate = array_keys($valid);
            }
        }

        $validatedData = collect($validatedData)->unique($this->uniqueIndex)->values()->all();
        switch ($this->modelName) {
            case 'hardwareTrait':
                HardwareTrait::upsert($validatedData, uniqueBy: [$this->uniqueIndex], update: $this->fieldsToUpdate);
                break;
            case 'Ram':
                Ram::upsert($validatedData, uniqueBy: [$this->uniqueIndex], update: $this->fieldsToUpdate);
                break;
            case 'Server':

                Server::upsert($validatedData, uniqueBy: [$this->uniqueIndex], update: $this->fieldsToUpdate);

                if (! empty($mtmMap)) {
                    $this->processServerRelations($mtmMap);
                }
                break;
        }
    }

    private function processServerRelations(array $mtmMap): void {
        $servers = Server::whereIn($this->uniqueIndex, array_keys($mtmMap))->get();
        foreach ($servers as $server) {
            $relationData = $mtmMap[$server->{$this->uniqueIndex}];
            $traitNames = array_map('trim', explode($relationData['delimiter'], $relationData['values']));
            $traitIds = HardwareTrait::whereIn('name', $traitNames)->pluck('id')->toArray();
            if (! empty($traitIds)) {
                $server->hardwareTraits()->syncWithoutDetaching(
                    $traitIds
                );
            }
        }
    }
}
