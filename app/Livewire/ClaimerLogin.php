<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ClaimerLogin extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function render()
    {
        return view('livewire.claimer-login');
    }

    public function login()
    {
        $this->validate();

        if (Auth::guard('claimer')->attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember)) {
            return redirect()->intended('/claimer/dashboard');
        }

        $this->addError('email', 'Invalid credentials');
    }
}
