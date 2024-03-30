<?php

namespace App\Livewire\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public bool $isResponsive = false;


    /**
     * Logout current logged user and redirect to home
     * @param Request $request
     * @return void
     */
    public function logout(Request $request): void
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $this->redirect(route('home'), true);
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
