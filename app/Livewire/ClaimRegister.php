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
        'avatar'    => 'required|image|max:2048',
    ];

    public function render()
    {
        return view('livewire.claim-register');
    }

    public function updatedAvatar()
    {
        $this->validateOnly('avatar');
        $this->previewAvatar = $this->avatar->temporaryUrl();
    }

    public function register()
    {
        $this->validate();

        $avatarPath = $this->avatar->store('avatars', 'public');

        Claimer::create([
            'email' => $this->email,
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'location' => $this->location,
            'dob' => $this->dob,
            'avatar' => $avatarPath,
        ]);
        return redirect()->route('claimer-login')->with('toast', [
            'type' => 'success',
            'message' => __('lang_v1.registration_successful'),
            'description' => __('lang_v1.you_can_now_login_with_your_credentials')
        ]);
    }
}
