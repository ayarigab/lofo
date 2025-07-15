<?php

namespace App\Livewire\Claimer;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class ChangePassword extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    public $remainingAttempts = 3;

    protected function rules()
    {
        return [
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::guard('claimer')->user()->password)) {
                        $fail(__('lang_v1.incorrect_password'));
                    }
                }
            ],
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ];
    }

    protected $messages = [
        'current_password' => 'lang_v1.incorrect_password',
        'new_password.confirmed' => 'lang_v1.password_confirmation_mismatch',
    ];

    public function updatePassword()
    {
        $this->validate();

        auth('claimer')->user()->update([
            'password' => Hash::make($this->new_password)
        ]);

        $this->dispatch('toast-show', [
            'data' => [
                'type' => 'success',
                'message' => __('lang_v1.action_successful'),
                'description' => __('lang_v1.password_updated_successfully')
            ]
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
    }

    public function render()
    {
        return view('livewire.claimer.change-password');
    }
}
