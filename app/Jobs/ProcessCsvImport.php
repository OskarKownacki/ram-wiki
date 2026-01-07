<?php

namespace App\Jobs;

use App\Models\HardwareTrait;
use App\Models\Ram;
use App\Models\Server;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProcessCsvImport implements ShouldQueue
{
    use Queueable;

    public array $data;

    public array $rules;

    public array $optionalFields;

    public string $uniqueIndex;

    public string $modelName;

    public $validatedData;

    public $fieldsToUpdate;

    public function __construct(array $data, array $rules, array $optionalFields, string $uniqueIndex, string $modelName)
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->optionalFields = $optionalFields;
        $this->uniqueIndex = $uniqueIndex;
        $this->modelName = $modelName;
    }

    public function handle(): void
    {
        foreach ($this->data as $data)
        {
            try
            {
                $validator = Validator::make($data, $this->rules);
                $validator->validate();
            }
            catch (ValidationException $e)
            {
                // Log::error('CSV import vaildation failed for traits on trait:' . $this->data['name'] . ' with errors: '  . json_encode($validator->errors()->all()));
                foreach ($validator->errors()->all() as $error)
                {
                    if (str_contains($error, 'required'))
                    {
                        throw $e;
                    }
                }
                foreach ($this->optionalFields as $field)
                {
                    if ($validator->errors()->has($field))
                    {
                        $data[$field] = null;
                        // Log::error('The field that didnt pass validation wasnt essential. It will be nulled, make sure to investigate the issue. Trait name: ' . $this->data["name"]);
                    }
                }
                $validator = Validator::make($data, $this->rules);
                $validator->validate();
            }

            $this->validatedData[] = $validator->validated();
            $this->fieldsToUpdate = array_keys($validator->validated());
        }
        switch ($this->modelName)
        {
            case 'hardwareTrait':
                HardwareTrait::upsert($this->validatedData, uniqueBy: [$this->uniqueIndex], update: $this->fieldsToUpdate);
                break;
            case 'Ram':
                Ram::upsert($this->validatedData, uniqueBy: [$this->uniqueIndex], update: $this->fieldsToUpdate);
                break;
            case 'Server':
                Server::upsert($this->validatedData, uniqueBy: [$this->uniqueIndex], update: $this->fieldsToUpdate);
                if (!empty($this->data['MtMInfo']) && !empty($this->data['MtMValue']))
                {
                    $server = Server::where($this->uniqueIndex, $this->validatedData[$this->uniqueIndex] ?? null)->first();
                    if ($server)
                    {
                        $traitNames = array_map('trim', explode($this->data['MtMDelimeter'], $this->data['MtMValue']));
                        foreach ($traitNames as $traitName)
                        {
                            $trait = HardwareTrait::where('name', $traitName)->first();
                            if ($trait)
                            {
                                $server->hardwareTraits()->syncWithoutDetaching($trait->id);
                            }
                        }
                    }
                }
                break;
        }
    }
}
