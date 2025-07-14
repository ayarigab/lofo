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
                $this->addError('email', __('lang_v1.please_check_your_email'));
                return;
            }

            if (!Hash::check($this->password, $claimer->password)) {
                $this->addError('password', __('lang_v1.incorrect_password'));
                return;
            }

            Auth::guard('claimer')->login($claimer, $this->remember);

            return redirect()->intended('/claimer/dashboard')->with('toast', [
                'type' => 'success',
                'message' => __('lang_v1.login_successful'),
                'description' => __('lang_v1.welcome_to_your_dashboard')
            ]);
        } catch (\Throwable $th) {
            $this->dispatch('toast-show', [
                'data' => [
                    'type' => 'danger',
                    'message' => __('lang_v1.error'),
                    'description' => __('auth.failed')
                ]
            ]);
        }

        $this->addError('email', __('auth.failed'));
    }
}
