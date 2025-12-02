<?php

namespace App\Interfaces;

interface CsvImportInterface
{
    public function importCsvFile(string $filePath, array $fields, string $modelName): void;
}
