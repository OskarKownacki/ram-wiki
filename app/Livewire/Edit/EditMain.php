<?php

namespace App\Livewire\Edit;

use App\Interfaces\CsvImportInterface;
use App\Models\HardwareTrait;
use App\Models\Ram;
use App\Models\Server;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class EditMain extends Component
{
    use WithFileUploads;

    #[Validate('file', 'mimes:csv', 'max:10240')]
    public $csv_file;

    public int $selectedTabId = 1;

    private CsvImportInterface $csvImportInterface;

    public $autocompleteTraitRam;

    public $hardwareTraitRam = '';

    public $manufacturer;

    public $producerCode;

    public $description;

    public $manufacturerServer;

    public $modelServer;

    public $autocompleteTraitsServer;

    public $hardwareTraitsServer = '';

    public function render()
    {
        return view('livewire.edit.edit-main');
    }

    public function setTab($tabId)
    {
        $this->selectedTabId = $tabId;

        $this->dispatch('scroll-to-tab', tabId: $tabId);
    }

    public function updatedHardwareTraitRam($value)
    {
        $this->autocompleteTraitRam = HardwareTrait::where('name', 'like', $value . '%')->take(5)->get();
    }

    public function updatedHardwareTraitsServer($value)
    {
        $this->autocompleteTraitsServer = HardwareTrait::where('name', 'like', $value . '%')->take(5)->get();
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
            $this->csvImportInterface->importCsvFile($path, $fieldsRam, 'Ram');
            $this->csv_file = null;
        }
        if ($this->selectedTabId === 2)
        {
            $this->csvImportInterface->importCsvFile($path, $fieldsServer, 'Server');
            $this->csv_file = null;
        }
        if ($this->selectedTabId === 3)
        {
            $this->csvImportInterface->importCsvFile($path, $fieldsTrait, 'hardwareTrait');
            $this->csv_file = null;
        }
    }

    public function saveRam()
    {
        $ram = new Ram();
        $ram->manufacturer = $this->manufacturer;
        $ram->description = $this->description;
        $ram->product_code = $this->producerCode;
        $ram->hardware_trait_id = HardwareTrait::where('name', '=', $this->hardwareTraits)->first()-> id ?? null;
        if ($ram->save())
        {
            $this->manufacturer = null;
            $this->description = null;
            $this->producerCode = null;
            $this->hardwareTraitRam = null;
            Toaster::success('Dodano RAMa!');
        }
    }

    public function saveServer()
    {
        $server = new Server();
        $server->manufacturer = $this->manufacturerServer;
        $server->model = $this->modelServer;
        if ($server->save())
        {
            $this->manufacturerServer = null;
            $this->modelServer = null;

            $server->hardwareTraits()->attach(
                HardwareTrait::where('name', '=', $this->hardwareTraitsServer)->first()-> id ?? null
            );
            $this->hardwareTraitsServer = null;
            Toaster::success('Dodano Serwer!');
        }
    }
}
