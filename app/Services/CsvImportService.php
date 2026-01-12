<?php

namespace App\Services;

use App\Interfaces\CsvImportInterface;
use App\Jobs\ProcessCsvImport;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class CsvImportService implements CsvImportInterface
{
    public function importCsvFile(string $filePath, int $tabId): void
    {
        $config = match ($tabId)
        {
            1       => ['fields' => config('csv-import.fields.ram'), 'type' => 'Ram'],
            2       => ['fields' => config('csv-import.fields.server'), 'type' => 'Server'],
            3       => ['fields' => config('csv-import.fields.trait'), 'type' => 'hardwareTrait'],
            default => throw new \Exception("Invalid Tab ID"),
        };

        $metadata = $this->prepareFieldsMetadata($config['fields']);

        SimpleExcelReader::create($filePath)
                ->getRows()
                ->chunk(200)
                ->each(function ($chunk) use ($config, $metadata)
                {
                    $fields = $config['fields'];
                    $modelName = $config['type'];

                    $batchData = [];

                    foreach ($chunk as $row)
                    {
                        $batchData[] = $this->map($row, $fields);
                    }
                    ProcessCsvImport::dispatch($batchData, $metadata['rules'], $metadata['optionalFields'], $metadata['uniqueIndex'], $modelName)->onQueue('csv_imports');
                });
    }

    public function prepareFieldsMetadata(array $fields)
    {
        $rules = [];
        $optionalFields = [];
        $uniqueIndex = '';
        foreach ($fields as $dbKey => $config)
        {
            if (!str_contains($config["rules"], 'required'))
            {
                $optionalFields[] = $dbKey;
            }
            if (isset($config["info"]["uniqueIndex"]) && $config["info"]["uniqueIndex"] === true)
            {
                $uniqueIndex = $dbKey;
            }
            $rules[$dbKey] = $config["rules"];
        }

        return [
            'rules'          => $rules,
            'optionalFields' => $optionalFields,
            'uniqueIndex'    => $uniqueIndex,
        ];
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
