<?php

namespace App\Livewire\Edit\Tabs;

use App\Interfaces\CsvImportInterface;
use App\Models\Server as ModelsServer;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class Server extends Component
{
    use WithFileUploads;

    public $hardwareTraitsServer = '';

    public $selectedTraits = [];

    public $manufacturerServer;

    public $modelServer;

    public $autocompleteTraitsServer = [];

    public $formRules;

    #[Validate('file', 'mimes:csv', 'max:10240')]
    public $csvFile;

    private CsvImportInterface $csvImportInterface;

    public function render()
    {
        return view('livewire.edit.tabs.server');
    }

    public function addTrait($value)
    {
        $value = trim($value);

        if (!empty($value) && !in_array($value, $this->selectedTraits))
        {
            $this->selectedTraits[] = $value;
        }

        $this->hardwareTraitsServer = '';
    }

    public function removeTrait($index)
    {
        unset($this->selectedTraits[$index]);
        $this->selectedTraits = array_values($this->selectedTraits); // Reindeksacja tablicy
    }

    public function saveServer()
    {
        $this->prepareRules(2);
        $this->validate($this->formRules);

        $server = new ModelsServer();
        $server->manufacturer = $this->manufacturerServer;
        $server->model = $this->modelServer;
        if ($server->save())
        {
            $this->manufacturerServer = null;
            $this->modelServer = null;
            $traitIds = [];
            foreach ($this->selectedTraits as $traitName)
            {
                $traitId = HardwareTrait::where('name', '=', $traitName)->first()-> id ?? null;
                if ($traitId)
                {
                    $traitIds[] = $traitId;
                }
            }
            $server->hardwareTraits()->syncWithoutDetaching(
                $traitIds
            );
            $this->hardwareTraitsServer = null;
            Toaster::success('Dodano Serwer!');
        }
    }

    public function updatedHardwareTraitsServer($value)
    {
        $this->autocompleteTraitsServer = HardwareTrait::where('name', 'like', $value . '%')->limit(5)->get();
        //dd($this->autocompleteTraitsServer);
    }

    public function prepareRules()
    {
        $fields = config('csv-import.fields.server');
        $map = [
            'manufacturer'      => 'manufacturerServer',
            'model'             => 'modelServer',
            'hardware_trait_id' => 'hardwareTraitsServer',

        ];
        foreach ($fields as $dbKey => $config)
        {
            if (isset($map[$dbKey]))
            {
                $wireKey = $map[$dbKey];
                $this->formRules[$wireKey] = $config["rules"];
            }
        }
    }

    public function boot(CsvImportInterface $csvImportInterface)
    {
        $this->csvImportInterface = $csvImportInterface;
    }

    public function uploadCsv()
    {
        $this->validate();

        $name = $this->csvFile->getClientOriginalName();
        $this->csvFile->storeAs(path: 'imports', name: $name);
        $path = storage_path('app/private/imports/' . $name);
        $this->csvImportInterface->importCsvFile($path, 2);
    }
}
