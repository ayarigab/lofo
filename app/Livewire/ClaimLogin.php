<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ClaimLogin extends Component
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
        return view('livewire.claim-login');
    }

    public function login()
    {
        $this->validate();


        try {
            if (Auth::guard('claimer')->attempt([
                'email' => $this->email,
                'password' => $this->password,
            ], $this->remember)) {
                return redirect()->intended('/claimer/dashboard')->with('toast', [
                    'type' => 'success',
                    'message' => 'Sign in success!',
                    'description' => 'Your login was successful, Welcome back.'
                ]);
            }
        } catch (\Throwable $th) {
            $this->dispatch('toast-show', [
                'data' => [
                    'type' => 'danger',
                    'message' => 'Oops! Login error',
                    'description' => 'Invalid credentials. Check your credentials and try again.'
                ]
            ]);
        }

        $this->addError('email', 'Invalid credentials');
    }
}
