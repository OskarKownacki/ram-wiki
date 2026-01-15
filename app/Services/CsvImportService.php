<?php

namespace App\Services;

use App\Interfaces\CsvImportInterface;
use App\Jobs\ProcessCsvImport;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class CsvImportService implements CsvImportInterface {
    public function importCsvFile(string $filePath, int $tabId): string {
        $config = match ($tabId) {
            1       => ['fields' => config('csv-import.fields.ram'), 'type' => 'Ram'],
            2       => ['fields' => config('csv-import.fields.server'), 'type' => 'Server'],
            3       => ['fields' => config('csv-import.fields.trait'), 'type' => 'hardwareTrait'],
            default => throw new \Exception('Invalid Tab ID'),
        };

        $metadata = $this->prepareFieldsMetadata($config['fields']);

        $jobs = [];

        SimpleExcelReader::create($filePath)
            ->getRows()
            ->chunk(200)
            ->each(function ($chunk) use ($config, $metadata, &$jobs) {
                $fields = $config['fields'];
                $modelName = $config['type'];

                $batchData = [];

                foreach ($chunk as $row) {
                    $batchData[] = $this->map($row, $fields);
                }

                $jobs[] = new ProcessCsvImport(
                    $batchData,
                    $metadata['rules'],
                    $metadata['optionalFields'],
                    $metadata['uniqueIndex'],
                    $modelName
                );
            });
        $batch = Bus::batch($jobs)
            ->name("CSV Import - {$config['type']}")
            ->onQueue('csv_imports')
            ->allowFailures()
            ->dispatch();

        return $batch->id;
    }

    public function prepareFieldsMetadata(array $fields) {
        $rules = [];
        $optionalFields = [];
        $uniqueIndex = '';
        foreach ($fields as $dbKey => $config) {
            if (! str_contains($config['rules'], 'required')) {
                $optionalFields[] = $dbKey;
            }
            if (isset($config['info']['uniqueIndex']) && $config['info']['uniqueIndex'] === true) {
                $uniqueIndex = $dbKey;
            }
            $rules[$dbKey] = $config['rules'];
        }

        return [
            'rules'          => $rules,
            'optionalFields' => $optionalFields,
            'uniqueIndex'    => $uniqueIndex,
        ];
    }

    public function map(array $row, array $fields) {
        $data = [];

        foreach ($fields as $dbKey => $config) {
            $value = $row[$config['csv']] ?? null;

            // Handle boolean fields - check for both 'bool' and 'boolean'
            if ($config['csv'] === 'Obsługa ECC' || $config['csv'] === 'Rejestrowanie (ECC Registered)') {
                $value = (strtolower($value ?? '') === 'tak') ? 1 : 0;
            }

            // Handle voltage field - convert "1.35V" to 1.35
            if ($dbKey === 'voltage_v') {
                if ($value === null || $value === '') {
                    $value = null;
                } else {
                    $value = str_replace(',', '.', $value);
                    $value = preg_replace('/[^0-9.]/', '', $value);

                    // Validate voltage is in reasonable range (0.5V - 5.0V)
                    if ($value !== '' && is_numeric($value)) {
                        $floatValue = (float) $value;
                        $value = ($floatValue >= 0.5 && $floatValue <= 5.0) ? $floatValue : null;
                    } else {
                        $value = null;
                    }
                }
            }

            if (isset($config['info'])) {
                if (isset($config['info']['relationship'])) {
                    $relatedTableName = $config['info']['relationship'];
                    $foreignKey = $config['info']['foreignKey'] ?? null;

                    $value = DB::table($relatedTableName)->where($foreignKey, $value)->first()->id ?? null;
                }
                if (isset($config['info']['MtM'])) {
                    $data['MtMInfo'] = $config['info']['MtM'];
                    $data['MtMValue'] = $value;

                    continue;
                }
                if (isset($config['info']['delimeter'])) {
                    $data['MtMDelimeter'] = $config['info']['delimeter'];
                }
            }

            $data[$dbKey] = $value;
        }

        return $data;
    }
}
