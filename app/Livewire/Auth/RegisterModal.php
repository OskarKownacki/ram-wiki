<?php

namespace App\Livewire\Auth;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RegisterModal extends Component {
    public $isOpen = false;

    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|string|email|max:255|unique:users')]
    public $email = '';

    #[Validate('required|string|min:8|confirmed')]
    public $password = '';

    #[Validate('string|same:password')]
    public $password_confirmation = '';

    public function mount() {
        if (Route::currentRouteName() === 'register') {
            $this->isOpen = true;
        }
    }

    public function register(): void {
        $validated = $this->validate();

        (new CreateNewUser())->create($validated);

        Auth::attempt([
            'email'    => $this->email,
            'password' => $this->password,
        ]);
        if (!Auth::check()) {
            $this->addError('email', 'Nie udało się zalogować nowego użytkownika.');
            return;
        }
        request()->session()->regenerate();
        $this->redirect(config('fortify.home'), navigate: true);
    }

    public function render() {
        return view('livewire.auth.register-modal');
    }

    public function openModal() {
        return $this->redirect(route('register'));
    }
}
