<?php

namespace App\Livewire\Home;

use App\Models\HardwareTrait;
use Livewire\Component;

class RamSearchResult extends Component
{
    public $foundRam;

    public $matchingServers = [];

    public function mount()
    {
        if (isset($this->foundRam->hardwareTrait->name)) {
            $this->matchingServers = HardwareTrait::with('servers')->where('name', $this->foundRam->hardwareTrait->name)->first()->servers;
        }
    }

    public function render()
    {
        return view('livewire.home.ram-search-result');
    }
}
