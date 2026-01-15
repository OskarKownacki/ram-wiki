<?php

namespace App\Interfaces;

interface CsvImportInterface {
    public function importCsvFile(string $filePath, int $tabId): string;
}
