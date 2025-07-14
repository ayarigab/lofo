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
    public $email;

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
            'avatar' => 'nullable|image|max:2048',
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

        $this->dispatch('toast-show', [
            'data' => [
                'type' => 'success',
                'message' => __('lang_v1.profile_updated'),
                'description' => __('lang_v1.your_profile_has_been_updated_successfully')
            ]
        ]);
        $this->avatarPreview = auth('claimer')->user()->avatar;
    }

    public function render()
    {
        return view('livewire.claimer.profile-edit');
    }
}
