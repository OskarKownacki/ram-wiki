<?php

namespace App\Livewire\Edit\Tabs;

use App\Interfaces\CsvImportInterface;
use App\Models\HardwareTrait;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class Ram extends Component
{
    use WithFileUploads;

    public $autocompleteTraitRam;

    public $hardwareTraitRam = '';

    public $manufacturer;

    public $producerCode;

    public $description;

    public $formRules;

    #[Validate('file|mimes:csv,txt|max:10240')]
    public $csvFile;

    public function render()
    {
        return view('livewire.edit.tabs.ram');
    }

    public function updatedHardwareTraitRam($value)
    {
        $this->autocompleteTraitRam = HardwareTrait::where('name', 'like', $value . '%')->limit(5)->get();
    }

    public function saveRam()
    {
        $this->prepareRules(1);
        $this->validate($this->formRules);
        $ram = new \App\Models\Ram();
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

    public function prepareRules()
    {
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
                $this->formRules[$wireKey] = $config["rules"];
            }
        }
    }

    public function uploadCsv(CsvImportInterface $csvImportInterface)
    {
        $this->validateOnly('csvFile');

        $name = $this->csvFile->getClientOriginalName();
        $this->csvFile->storeAs(path: 'imports', name: $name);
        $path = storage_path('app/private/imports/' . $name);
        $csvImportInterface->importCsvFile($path, 1);
    }
}
