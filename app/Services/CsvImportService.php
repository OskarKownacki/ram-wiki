<?php

namespace App\Services;

use App\Interfaces\CsvImportInterface;
use App\Jobs\ProcessCsvImport;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class CsvImportService implements CsvImportInterface
{
    public array $rules;

    public array $optionalFields;

    public string $uniqueIndex;

    public function importCsvFile(string $filePath, array $fields, string $modelName): void
    {
        SimpleExcelReader::create($filePath)
                ->getRows()
                ->chunk(200)
                ->each(function ($chunk) use ($fields, $modelName)
                {
                    $batchData = [];
                    $this->prepareFieldsMetadata($fields);
                    foreach ($chunk as $row)
                    {
                        $batchData[] = $this->map($row, $fields);
                    }
                    ProcessCsvImport::dispatch($batchData, $this->rules, $this->optionalFields, $this->uniqueIndex, $modelName)->onQueue('csv_imports');
                });
    }

    public function prepareFieldsMetadata(array $fields)
    {
        $this->rules = [];
        $this->optionalFields = [];
        $this->uniqueIndex = '';
        foreach ($fields as $dbKey => $config)
        {
            if (!str_contains($config["rules"], 'required'))
            {
                $this->optionalFields[] = $dbKey;
            }
            if (isset($config["info"]["uniqueIndex"]) && $config["info"]["uniqueIndex"] === true)
            {
                $this->uniqueIndex = $dbKey;
            }
            $this->rules[$dbKey] = $config["rules"];
        }
    }

    public function map(array $row, array $fields)
    {
        foreach ($fields as $dbKey => $config)
        {
            if (str_contains($config["rules"], 'bool'))
            {
                $row[$config["csv"]] = (strtolower($row[$config["csv"]]) === 'tak') ? true : false;
            }
            if (isset($config["info"]))
            {
                if (isset($config["info"]["relationship"]))
                {
                    $relatedTableName = $config["info"]["relationship"];
                    $foreignKey = $config["info"]["foreignKey"] ?? null;

                    $row[$config["csv"]] = DB::table($relatedTableName)->where($foreignKey, $row[$config["csv"]])->first()->id ?? null;
                }
                if (isset($config["info"]["MtM"]))
                {
                    $data['MtMInfo'] = $config["info"]["MtM"];
                    $data['MtMValue'] = $row[$config["csv"]];
                    continue;
                }
                if (isset($config["info"]["delimeter"]))
                {
                    $data['MtMDelimeter'] = $config["info"]["delimeter"];
                }
            }

            $data[$dbKey] = $row[$config["csv"]] ?? null;
        }
        return $data;
    }
}
