<?php

namespace App\Livewire\Claimer;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Claimer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileEdit extends Component
{
    use WithFileUploads;

    public $full_name;
    public $location;
    public $dob;
    public $phone;
    public $avatar;
    public $avatarPreview;
    public $email; // Display only

    protected function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'dob' => 'nullable|date|before:today',
            'phone' => [
                'required',
                'string',
                Rule::unique('claimers')->ignore(Auth::guard('claimer')->id()),
            ],
            'avatar' => 'nullable|image|max:2048', // 2MB max
        ];
    }

    public function mount()
    {
        $claimer = Auth::guard('claimer')->user();
        $this->full_name = $claimer->full_name;
        $this->location = $claimer->location;
        $this->dob = $claimer->dob?->toDateString();
        $this->phone = $claimer->phone;
        $this->email = $claimer->email;
        $this->avatarPreview = $claimer->avatar;
    }

    public function updatedAvatar()
    {
        $this->validateOnly('avatar');
        $this->avatarPreview = $this->avatar->temporaryUrl();
    }

    public function save()
    {
        $this->validate();

        $claimer = Claimer::find(Auth::guard('claimer')->id());

        $data = [
            'full_name' => $this->full_name,
            'location' => $this->location,
            'dob' => $this->dob,
            'phone' => $this->phone,
        ];

        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $claimer->update($data);

        $this->dispatch('notify', type: 'success', message: 'Profile updated successfully!');
        $this->avatarPreview = $claimer->fresh()->avatar;
        $this->avatar = null;
    }

    public function render()
    {
        return view('livewire.claimer.profile-edit');
    }
}
