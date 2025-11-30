<?php

namespace App\Interfaces;

interface CsvImportInterface
{
    public function importHardwareTraitsFile(string $filePath): void;
}
