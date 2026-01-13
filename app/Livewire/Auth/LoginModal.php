<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class LoginModal extends Component
{
    public $isOpen = false;

    public $email = '';

    public $password = '';

    protected $rules = [
        'email'    => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password]))
        {
            session()->regenerate();
            $url = url()->previous();
            return redirect($url);
        }

        $this->addError('email', 'Błędne dane logowania.');
    }

    public function mount()
    {
        if (Route::currentRouteName() === 'login')
        {
            $this->isOpen = true;
        }
    }

    public function render()
    {
        return view('livewire.auth.login-modal');
    }
}
