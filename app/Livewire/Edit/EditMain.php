<?php

namespace App\Livewire\Edit;

use App\Interfaces\CsvImportInterface;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditMain extends Component
{
    use WithFileUploads;

    #[Validate('file', 'mimes:csv', 'max:10240')]
    public $csv_file;

    public int $selectedTabId = 1;

    private CsvImportInterface $csvImportInterface;

    public function render()
    {
        return view('livewire.edit.edit-main');
    }

    public function setTab($tabId)
    {
        $this->selectedTabId = $tabId;
    }

    public function boot(CsvImportInterface $csvImportInterface)
    {
        $this->csvImportInterface = $csvImportInterface;
    }

 public function uploadRamsCsv()
 {
     $this->validate();
     $name = $this->csv_file->getClientOriginalName();
     $this->csv_file->storeAs(path: 'imports', name: $name);
     $path = storage_path('app/private/imports/' . $name);
     $fields = [
         'product_code' => [
             'csv'   => 'Symbol',
             'rules' => 'required|string',
             'info'  => 'uniqueIndex',
         ],
         'description' => [
             'csv'   => 'Opis',
             'rules' => 'required|string',
         ],
         'manufacturer' => [
             'csv'   => 'Producent',
             'rules' => 'string',
         ],
         'hardware_trait_id' => [
             'csv'   => 'Cecha',
             'rules' => 'string',
             'info'  => 'relationship: hardware_traits|id',
         ],
     ];

     if ($this->selectedTabId === 1)
     {
         $this->csvImportInterface->importCsvFile($path, $fields);
     }
 }

    public function uploadTraitsCsv()
    {
        $this->validate();
        $name = $this->csv_file->getClientOriginalName();
        $this->csv_file->storeAs(path: 'imports', name: $name);
        $path = storage_path('app/private/imports/' . $name);


        $fields = [
            'name' => [
                'csv'   => 'Nazwa',
                'rules' => 'required|string',
                'info'  => 'uniqueIndex',
            ],
            'capacity' => [
                'csv'   => 'Pojemność całkowita',
                'rules' => 'required|string',
            ],
            'bundle' => [
                'csv'   => 'Zestaw',
                'rules' => 'required|string',
            ],
            'type' => [
                'csv'   => 'Typ',
                'rules' => 'required|string',
            ],
            'rank' => [
                'csv'   => 'Rank',
                'rules' => 'required|string',
            ],
            'memory_type' => [
                'csv'   => 'Rodzaj pamięci',
                'rules' => 'required|string',
            ],
            'ecc_support' => [
                'csv'   => 'Obsługa ECC',
                'rules' => 'required|boolean',
            ],
            'ecc_registered' => [
                'csv'   => 'Rejestrowanie (ECC Registered)',
                'rules' => 'boolean',
            ],
            'speed' => [
                'csv'   => 'Szybkość modułu',
                'rules' => 'required|string',
            ],
            'frequency' => [
                'csv'   => 'Częstotliwość',
                'rules' => 'required|string',
            ],
            'cycle_latency' => [
                'csv'   => 'Opóźnienie (Cycle Latency)',
                'rules' => 'string',
            ],
            'voltage_v' => [
                'csv'   => 'Napięcie (V)',
                'rules' => 'numeric|nullable',
            ],
            'bus' => [
                'csv'   => 'Złącze',
                'rules' => 'string',
            ],
            'module_build' => [
                'csv'   => 'Budowa modułu',
                'rules' => 'string',
            ],
            'module_ammount' => [
                'csv'   => 'Liczba modułów',
                'rules' => 'string',
            ],
            'guarancy' => [
                'csv'   => 'Gwarancja',
                'rules' => 'string',
            ],
        ];

        if ($this->selectedTabId === 1)
        {
            $this->csvImportInterface->importCsvFile($path, $fields);
        }
    }
}
