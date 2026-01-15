<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LoginModal extends Component {
    public $isOpen = false;

    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $password = '';

    public function mount() {
        if (Route::currentRouteName() === 'login') {
            $this->isOpen = true;
        }
    }

    public function login(): void {
        $validated = $this->validate();

        if (Auth::attempt($validated)) {
            request()->session()->regenerate();
            $this->redirect(config('fortify.home'), navigate: true);
        }
        else {
            $this->addError('email', 'Dane logowania są nieprawidłowe.');
        }
    }

    public function render() {
        return view('livewire.auth.login-modal');
    }

    public function openModal() {
        return $this->redirect(route('login'));
    }
}
