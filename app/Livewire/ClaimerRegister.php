<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Claimer;
use Illuminate\Support\Facades\Hash;

class ClaimerRegister extends Component
{
    public $email;
    public $full_name;
    public $phone;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'email'     => 'required|email|unique:claimers',
        'full_name' => 'required|string|max:255',
        'phone'     => 'required|unique:claimers|max:20',
        'location'  => 'required|string|max:255',
        'dob'       => 'required|date',
        'password'  => 'required|confirmed|min:8',
        'avatar'    => 'nullable|string',

        'email',
        'full_name',
        'location',
        'dob',
        'phone',
        'password',
        'avatar'
    ];

    public function render()
    {
        return view('livewire.claimer-register');
    }

    public function register()
    {
        $this->validate();

        Claimer::create([
            'email' => $this->email,
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);

        $this->dispatch(
            'toast-show',
            type: 'success',
            message: 'Report Submitted',
            description: 'Your lost item report has been successfully submitted'
        );

        return redirect()->route('claimer.login')->with('success', 'Registration successful!');
    }
}
