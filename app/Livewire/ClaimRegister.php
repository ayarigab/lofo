<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Claimer;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

class ClaimRegister extends Component
{
    use WithFileUploads;

    public $email;
    public $full_name;
    public $phone;
    public $location;
    public $dob;
    public $password;
    public $password_confirmation;
    public $avatar;

    public $previewAvatar;

    protected $rules = [
        'email'     => 'required|email|unique:claimers',
        'full_name' => 'required|string|max:255',
        'phone'     => 'required|unique:claimers|max:20',
        'location'  => 'required|string|max:255',
        'dob'       => 'required|date',
        'password'  => 'required|confirmed|min:8',
        'avatar'    => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    public function render()
    {
        return view('livewire.claim-register');
    }

    public function updatedImage()
    {
        $this->validateOnly('avatar');
        $this->previewAvatar = $this->avatar->temporaryUrl();
    }

    public function register()
    {
        $this->validate();

        $avatarPath = $this->avatar->store('users', 'public');

        Claimer::create([
            'email' => $this->email,
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'location' => $this->phone,
            'dob' => $this->phone,
            'avatar' => $avatarPath,
        ]);

        $this->dispatch(
            'toast-show',
            type: 'success',
            message: 'Report Submitted',
            description: 'Your lost item report has been successfully submitted'
        );

        return redirect()->route('claimer-login')->with('success', 'Registration successful!');
    }
}
