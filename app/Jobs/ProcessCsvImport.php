<?php

namespace App\Jobs;

use App\Models\HardwareTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProcessCsvImport implements ShouldQueue
{
    use Queueable;

    public array $row;

    public function __construct(array $row)
    {
        $this->row = $row;
    }

    public function handle(): void
    {

        $eccSupport = (strtolower($this->row['Obsługa ECC']) === 'tak') ? true : false;
        $eccRegistered = (strtolower($this->row['Rejestrowanie (ECC Registered)']) === 'tak') ? true : false;
        $data = [
            'name'           => $this->row['Nazwa'],
            'capacity'       => $this->row['Pojemność całkowita'],
            'bundle'         => $this->row['Zestaw'],
            'type'           => $this->row['Typ'],
            'rank'           => $this->row['Rank'],
            'memory_type'    => $this->row['Rodzaj pamięci'],
            'ecc_support'    => $eccSupport,
            'ecc_registered' => $eccRegistered,
            'speed'          => $this->row['Szybkość modułu'],
            'frequency'      => $this->row['Częstotliwość'],
            'cycle_latency'  => $this->row['Opóźnienie (Cycle Latency)'],
            'voltage_v'      => $this->row['Napięcie (V)'],
            'bus'            => $this->row['Złącze'],
            'module_build'   => $this->row['Budowa modułu'],
            'module_ammount' => $this->row['Liczba modułów'],
            'guarancy'       => $this->row['Gwarancja'],
        ];

        try {
            $validator = Validator::make($data, [
                'name'           => 'required|string',
                'capacity'       => 'required|string',
                'bundle'         => 'required|string',
                'type'           => 'required|string',
                'rank'           => 'required|string',
                'memory_type'    => 'required|string',
                'ecc_support'    => 'required|boolean',
                'ecc_registered' => 'boolean',
                'speed'          => 'required|string',
                'frequency'      => 'required|string',
                'cycle_latency'  => 'string',
                'voltage_v'      => 'numeric',
                'bus'            => 'string',
                'module_build'   => 'string',
                'module_ammount' => 'string',
                'guarancy'       => 'string',
            ]);
        } catch (ValidationException $e) {
            if ($validator->fails()) {
                Log::error('CSV import vaildation failed for traits on trait:' . $data['name'] . ' with errors: '  . json_encode($validator->errors()->all()));
            }
        }

        $data = $validator->validated();
        $dataToUpdate = ['name', 'capacity', 'bundle', 'type', 'rank', 'memory_type', 'ecc_support', 'ecc_registered', 'speed', 'frequency', 'cycle_latency', 'voltage_v', 'bus', 'module_build', 'module_ammount', 'guarancy'];
        HardwareTrait::upsert([$data], uniqueBy: ['name'], update: $dataToUpdate);
    }
}
