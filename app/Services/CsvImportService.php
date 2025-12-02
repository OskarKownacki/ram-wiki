<?php

namespace App\Services;

use App\Interfaces\CsvImportInterface;
use App\Jobs\ProcessCsvImport;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class CsvImportService implements CsvImportInterface
{
    public function importCsvFile(string $filePath, array $fields, string $modelName): void
    {
        $rows = SimpleExcelReader::create($filePath)->getRows();
        foreach ($rows as $row)
        {
            $mappedData = $this->map($row, $fields);
            ProcessCsvImport::dispatch($mappedData['data'], $mappedData['rules'], $mappedData["optionalFields"], $mappedData['uniqueIndex'], $modelName)->onQueue('csv_imports');
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
                if (str_contains($config["info"], 'uniqueIndex'))
                {
                    $uniqueIndex = $dbKey;
                }
                if (str_contains($config["info"], 'relationship'))
                {
                    $strArray = explode("|", $config["info"]);
                    foreach ($strArray as $str)
                    {
                        if (str_contains($str, 'relationship'))
                        {
                            $relatedTableName = str_replace('relationship:', "", $str);
                        }
                        if (str_contains($str, 'foreignKey'))
                        {
                            $foreignKey = str_replace('foreignKey:', "", $str);
                        }
                    }
                    $row[$config["csv"]] = DB::table($relatedTableName)->where($foreignKey, $row[$config["csv"]])->first()->id ?? null;
                }
            }
            if (!str_contains($config["rules"], 'required'))
            {
                $optionalFields[] = $dbKey;
            }

            $data[$dbKey] = $row[$config["csv"]];
            $rules[$dbKey] = $config["rules"];
        }

        return ['data' => $data, 'rules' => $rules, 'optionalFields' => $optionalFields, 'uniqueIndex' => $uniqueIndex];
    }
}
