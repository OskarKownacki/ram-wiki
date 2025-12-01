<?php

namespace App\Interfaces;

interface CsvImportInterface
{
    public function importHardwareTraitsFile(string $filePath, array $fields, array $booleanIndices, array $optionalFields, string $uniqueIndex): void;
}
