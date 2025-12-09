<?php

namespace App\Livewire\Home;

use App\Models\Server;
use Livewire\Component;

class RamSearchResult extends Component
{
    public $foundRam;

    public $matchingServers;

    public function boot()
    {
        $this->matchingServers = Server::
    }

    public function render()
    {
        return view('livewire.home.ram-search-result');
    }
}
