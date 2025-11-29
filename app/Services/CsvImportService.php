<?php

namespace App\Services;

use App\Jobs\ProcessCsvImport;
use Spatie\SimpleExcel\SimpleExcelReader;

class CsvImportService
{
    public function importFile($filePath)
    {
        $rows = SimpleExcelReader::create($filePath)->getRows();
        foreach ($rows as $row) {
            ProcessCsvImport::dispatch($row)->onQueue('csv_imports');
        }
    }
}
