<?php

namespace App\Livewire\Edit;

use Livewire\Component;

class EditMain extends Component
{
    public int $selectedTabId = 1;
    public function render()
    {
        return view('livewire.edit.edit-main');
    }
    public function setTab($tabId)
    {
        $this->selectedTabId = $tabId;
    }
}
