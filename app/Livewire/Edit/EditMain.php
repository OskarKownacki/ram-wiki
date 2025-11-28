<?php

namespace App\Livewire\Edit;

use App\Services\CsvImportService;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditMain extends Component
{
    use WithFileUploads;

    #[Validate('file', 'mimes:csv', 'max:10240')]
    public $csv_file;

    public int $selectedTabId = 1;

    private CsvImportService $csvImportService;

    public function render()
    {

        return view('livewire.edit.edit-main');
    }

    public function setTab($tabId)
    {
        $this->selectedTabId = $tabId;
    }

    public function boot(CsvImportService $csvImportService)
    {
        $this->csvImportService = $csvImportService;
    }

    public function uploadCsv()
    {
        $this->validate();
        $name = $this->csv_file->getClientOriginalName();
        $this->csv_file->storeAs(path: 'imports', name: $name);
        $path = storage_path('app/private/imports/' . $name);
        $this->csvImportService->importFile($path);
    }
}
