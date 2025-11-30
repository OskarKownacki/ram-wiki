<?php

namespace App\Services;

use App\Jobs\ProcessCsvImport;
use CsvImportInterface;
use Spatie\SimpleExcel\SimpleExcelReader;

class CsvImportService implements CsvImportInterface
{
    public function importHardwareTraitsFile(string $filePath): void
    {
        $rows = SimpleExcelReader::create($filePath)->getRows();
        foreach ($rows as $row)
        {
            ProcessCsvImport::dispatch($row)->onQueue('csv_imports');
        }
    }
}
