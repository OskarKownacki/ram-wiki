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

    public $autocompleteTraitsServer = [];

    public $hardwareTraitsServer = '';

    public $selectedTraits = [];

    public $nameTrait;

    public $capacityTrait;

    public $bundleTrait;

    public $typeTrait;

    public $memoryTypeTrait;

    public $rules;

    public $speedTrait;

    public $rankTrait;

    public $voltageTrait;

    public bool $eccSupportTrait = false;

    public bool $eccRegisteredTrait = false;

    public $frequencyTrait;

    public $cycleLatencyTrait;

    public $portTrait;

    public $moduleBuildTrait;

    public $moduleAmmountTrait;

    public $guarancyTrait;

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
        $this->autocompleteTraitRam = HardwareTrait::where('name', 'like', $value . '%')->limit(5)->get();
    }

    public function updatedHardwareTraitsServer($value)
    {
        $this->autocompleteTraitsServer = HardwareTrait::where('name', 'like', $value . '%')->limit(5)->get();
        //dd($this->autocompleteTraitsServer);
    }

    public function boot(CsvImportInterface $csvImportInterface)
    {
        $this->csvImportInterface = $csvImportInterface;
    }

    public function prepareRules($tabId)
    {
        switch ($tabId)
        {
            case 1:
                $fields = config('csv-import.fields.ram');

                $map = [
                    'manufacturer'      => 'manufacturer',
                    'description'       => 'description',
                    'product_code'      => 'producerCode',
                    'hardware_trait_id' => 'hardwareTraitRam',
                ];

                foreach ($fields as $dbKey => $config)
                {
                    if (isset($map[$dbKey]))
                    {
                        $wireKey = $map[$dbKey];
                        $this->rules[$wireKey] = $config["rules"];
                    }
                }
                break;
            case 2:
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
                        $this->rules[$wireKey] = $config["rules"];
                    }
                }
                break;
            case 3:
                $fields = config('csv-import.fields.trait');
                $map = [
                    'name'           => 'nameTrait',
                    'capacity'       => 'capacityTrait',
                    'bundle'         => 'bundleTrait',
                    'type'           => 'typeTrait',
                    'memory_type'    => 'memoryTypeTrait',
                    'speed'          => 'speedTrait',
                    'rank'           => 'rankTrait',
                    'voltage_v'      => 'voltageTrait',
                    'ecc_support'    => 'eccSupportTrait',
                    'ecc_registered' => 'eccRegisteredTrait',
                    'frequency'      => 'frequencyTrait',
                    'cycle_latency'  => 'cycleLatencyTrait',
                    'bus'            => 'portTrait',
                    'module_build'   => 'moduleBuildTrait',
                    'module_ammount' => 'moduleAmmountTrait',
                    'guarancy'       => 'guarancyTrait',
                ];
                foreach ($fields as $dbKey => $config)
                {
                    if (isset($map[$dbKey]))
                    {
                        $wireKey = $map[$dbKey];
                        $this->rules[$wireKey] = $config["rules"];
                    }
                }
                break;
        }
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
        $this->prepareRules(1);
        $this->validate($this->rules);
        $ram = new Ram();
        $ram->manufacturer = $this->manufacturer;
        $ram->description = $this->description;
        $ram->product_code = $this->producerCode;
        $ram->hardware_trait_id = HardwareTrait::where('name', '=', $this->hardwareTraitRam)->first()-> id ?? null;
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
        $this->prepareRules(2);
        $this->validate($this->rules);

        $server = new Server();
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

    public function addTrait($value)
    {
        $value = trim($value);

        // Walidacja: czy nie jest puste i czy już nie istnieje w tablicy
        if (!empty($value) && !in_array($value, $this->selectedTraits))
        {
            $this->selectedTraits[] = $value;
        }

        // Resetowanie pola wyszukiwania
        $this->hardwareTraitsServer = '';
    }

    public function removeTrait($index)
    {
        unset($this->selectedTraits[$index]);
        $this->selectedTraits = array_values($this->selectedTraits); // Reindeksacja tablicy
    }

    public function saveTrait()
    {
        $this->prepareRules(3);
        $this->validate($this->rules);

        $trait = new HardwareTrait();
        $trait->name = $this->nameTrait;
        $trait->capacity = $this->capacityTrait;
        $trait->bundle = $this->bundleTrait;
        $trait->type = $this->typeTrait;
        $trait->speed = $this->speedTrait;
        $trait->rank = $this->rankTrait;
        $trait->voltage_v = $this->voltageTrait;
        $trait->ecc_support = $this->eccSupportTrait;
        $trait->ecc_registered = $this->eccRegisteredTrait;
        $trait->frequency = $this->frequencyTrait;
        $trait->cycle_latency = $this->cycleLatencyTrait;
        $trait->bus = $this->portTrait;
        $trait->module_build = $this->moduleBuildTrait;
        $trait->module_ammount = $this->moduleAmmountTrait;
        $trait->memory_type = $this->memoryTypeTrait;
        $trait->guarancy = $this->guarancyTrait;

        if ($trait->save())
        {
            $this->nameTrait = null;
            $this->capacityTrait = null;
            $this->bundleTrait = null;
            $this->typeTrait = null;
            $this->speedTrait = null;
            $this->rankTrait = null;
            $this->voltageTrait = null;
            $this->eccSupportTrait = false;
            $this->eccRegisteredTrait = false;
            $this->frequencyTrait = null;
            $this->cycleLatencyTrait = null;
            $this->portTrait = null;
            $this->moduleBuildTrait = null;
            $this->moduleAmmountTrait = null;
            $this->memoryTypeTrait = null;
            $this->guarancyTrait = null;

            Toaster::success('Dodano cechę RAMa!');
        }
    }
}
