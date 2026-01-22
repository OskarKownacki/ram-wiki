<?php

namespace App\Livewire;

use App\Models\Ram;
use Livewire\Component;

class HomePage extends Component
{
    public string $searchValue;

    public $autocompleteValues;

    public $foundRams;

    public function updatedSearchValue($value)
    {
        $this->autocompleteValues = Ram::where('product_code', 'like', $value.'%')->take(5)->get();
    }

    public function render()
    {
        return view('livewire.home-page');
    }

    public function onSearchSubmit()
    {
        $this->foundRams = null;
        $this->foundRams = Ram::with('hardwareTrait')->where('product_code', '=', $this->searchValue)->get();
    }
}
