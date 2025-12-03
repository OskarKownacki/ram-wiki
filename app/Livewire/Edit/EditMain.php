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

    public function uploadCsv()
    {
        $this->validate();
        $name = $this->csv_file->getClientOriginalName();
        $this->csv_file->storeAs(path: 'imports', name: $name);
        $path = storage_path('app/private/imports/' . $name);

        $fieldsRam = config('csv-import.fields.ram');


        $fieldsTrait = config('csv-import.fields.trait');

        $fieldsServer = config('csv-import.fields.server');

        if ($this->selectedTabId === 1)
        {
            $this->csvImportInterface->importCsvFile($path, $fieldsRam, 'hardwareTrait');
            $this->csv_file = null;
        }
        if ($this->selectedTabId === 2)
        {
            $this->csvImportInterface->importCsvFile($path, $fieldsServer, 'Server');
            $this->csv_file = null;
        }
        if ($this->selectedTabId === 3)
        {
            $this->csvImportInterface->importCsvFile($path, $fieldsTrait, 'Ram');
            $this->csv_file = null;
        }
    }
}
