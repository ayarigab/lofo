<?php

namespace App\Livewire\Claimer;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePassword extends Component
{
    public $current_password;
    public $new_password;
    public $confirm_password;
    public $remainingAttempts = 3;

    protected function rules()
    {
        return [
            'current_password' => ['required', 'current_password'],
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
        'current_password.current_password' => 'lang_v1.incorrect_password',
    ];

    public function updatePassword()
    {
        $this->validate();

        auth('claimer')->user()->update([
            'password' => Hash::make($this->new_password)
        ]);

        session()->flash('message', __('lang_v1.password_updated_successfully'));

        $this->reset(['current_password', 'new_password', 'confirm_password']);
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.claimer.change-password');
    }
}
