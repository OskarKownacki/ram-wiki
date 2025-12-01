<?php

namespace App\Jobs;

use App\Models\HardwareTrait;
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

    public function __construct(array $data, array $rules, array $optionalFields, string $uniqueIndex)
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->optionalFields = $optionalFields;
        $this->uniqueIndex = $uniqueIndex;
    }

    public function handle(): void
    {
        try
        {
            $validator = Validator::make($this->data, $this->rules);
            $validator->validate();
        }
        catch (ValidationException $e)
        {
            Log::error('CSV import vaildation failed for traits on trait:' . $this->data['name'] . ' with errors: '  . json_encode($validator->errors()->all()));
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
                    $this->data[$field] = null;
                    Log::error('The field that didnt pass validation wasnt essential. It will be nulled, make sure to investigate the issue. Trait name: ' . $this->data["name"]);
                }
            }
            $validator = Validator::make($this->data, $this->rules);
            $validator->validate();
        }

        $validatedData = $validator->validated();
        $fieldsToUpdate = array_keys($validatedData);
        HardwareTrait::upsert([$validatedData], uniqueBy: [$this->uniqueIndex], update: $fieldsToUpdate);
    }
}
