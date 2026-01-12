<?php

namespace App\Livewire\Edit\Tabs;

use App\Interfaces\CsvImportInterface;
use App\Models\HardwareTrait as ModelsHardwareTrait;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class HardwareTrait extends Component
{
    use WithFileUploads;

    public $nameTrait;

    public $capacityTrait;

    public $bundleTrait;

    public $typeTrait;

    public $memoryTypeTrait;

    public $formRules;

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

    #[Validate('file', 'mimes:csv', 'max:10240')]
    public $csvFile;

    private CsvImportInterface $csvImportInterface;

    public function render()
    {
        return view('livewire.edit.tabs.hardware-trait');
    }

    public function saveTrait()
    {
        $this->prepareRules(3);
        $this->validate($this->formRules);

        $trait = new ModelsHardwareTrait();
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

    public function prepareRules()
    {
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
        $this->csvImportInterface->importCsvFile($path, 3);
    }
}
