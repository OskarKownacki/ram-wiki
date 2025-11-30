<?php

interface CsvImportInterface
{
    public function importHardwareTraitsFile(string $filePath): void;
}
