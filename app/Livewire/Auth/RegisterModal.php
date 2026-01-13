<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Route;
use Livewire\Component;

class RegisterModal extends Component
{
    public $isOpen = false;

    public $name = '';

    public $email = '';

    public $password = '';

    public $password_confirmation = '';

    public function register()
    {
        $this->validate([
            'email'    => 'required|email|string|max:255',
            'password' => 'required|string|confirmed|min:8',
            'name'     => 'required|string|max:255']);

        $creator = app(\App\Actions\Fortify\CreateNewUser::class);
        $user = $creator->create([
            'name'                  => $this->name,
            'email'                 => $this->email,
            'password'              => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ]);

        \Auth::login($user);
        $url = url()->previous();
        return redirect($url);
    }

    public function mount()
    {
        if (Route::currentRouteName() === 'register')
        {
            $this->isOpen = true;
        }
    }

    public function render()
    {
        return view('livewire.auth.register-modal');
    }
}
