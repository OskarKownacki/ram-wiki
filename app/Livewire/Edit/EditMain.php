<?php

namespace App\Livewire\Edit;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditMain extends Component
{
    use WithFileUploads;

    #[Validate('file', 'mimes:csv', 'max:10240')]
    public $csv_file;

    public int $selectedTabId = 1;

    public function render()
    {
        return view('livewire.edit.edit-main');
    }

    public function setTab($tabId)
    {
        $this->selectedTabId = $tabId;

        $this->dispatch('scroll-to-tab', tabId: $tabId);
    }
}
