<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\Auth\LoginForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public LoginForm $form;

    /**
     * Authenticate user with the given credentials
     * @return void
     */
    public function authenticate(): void
    {
        $credentials = [
            'email' => $this->form->email,
            'password' => $this->form->password,
        ];
        $checkAuth = Auth::attempt($credentials);

        if(!$checkAuth)
        {
            $this->addError('login','Wrong email or password.');
            return;
        }

        $this->redirect(route('admin.dashboard'), true);
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
