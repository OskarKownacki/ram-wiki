<?php

namespace App\Services;

use App\Interfaces\CsvImportInterface;
use App\Jobs\ProcessCsvImport;
use Spatie\SimpleExcel\SimpleExcelReader;

class CsvImportService implements CsvImportInterface
{
    public function importHardwareTraitsFile(string $filePath, array $fields, array $booleanIndices, array $optionalFields, string $uniqueIndex): void
    {
        $rows = SimpleExcelReader::create($filePath)->getRows();
        foreach ($rows as $row)
        {
            $mappedData = $this->map($row, $fields, $booleanIndices);
            ProcessCsvImport::dispatch($mappedData['data'], $mappedData['rules'], $optionalFields, $uniqueIndex)->onQueue('csv_imports');
        }
    }

    public function map(array $row, array $fields, $booleanIndices)
    {
        $row = $this->parseBoolean($booleanIndices, $row);
        $data = [];
        $rules = [];
        foreach ($fields as $dbKey => $config)
        {
            $data[$dbKey] = $row[$config["csv"]];
            $rules[$dbKey] = $config["rules"];
        }

        return ['data' => $data, 'rules' => $rules];
    }

    public function parseBoolean($booleanIndices, $row)
    {
        foreach ($booleanIndices as $booleanIndex)
        {
            $row[$booleanIndex] = (strtolower($row[$booleanIndex]) === 'tak') ? true : false;
        }
        return $row;
    }
}
