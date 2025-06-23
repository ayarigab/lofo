<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Claimer;

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
            $claimer = Claimer::where('email', $this->email)->first();

            if (!$claimer) {
                $this->addError('email', 'Invalid credentials');
                return;
            }

            if (!Hash::check($this->password, $claimer->password)) {
                $this->addError('email', 'Invalid credentials');
                return;
            }

            Auth::guard('claimer')->login($claimer, $this->remember);

            return redirect()->intended('/claimer/dashboard')->with('toast', [
                'type' => 'success',
                'message' => 'Login successful',
                'description' => 'Welcome back!'
            ]);
        } catch (\Throwable $th) {
            $this->dispatch('toast-show', [
                'data' => [
                    'type' => 'danger',
                    'message' => 'Login failed',
                    'description' => 'The provided credentials are incorrect.'
                ]
            ]);
        }

        $this->addError('email', 'Invalid credentials');
    }
}
