<?php

namespace App\Services;

use Spatie\SimpleExcel\SimpleExcelReader;

class CsvImportService
{
    public function importFile($filePath)
    {
        $rows = SimpleExcelReader::create($filePath)->getRows();

    }
}
