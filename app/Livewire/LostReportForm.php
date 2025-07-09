<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LostReport;
use Illuminate\Support\Facades\Auth;

class LostReportForm extends Component
{
    public $full_name;
    public $email;
    public $phone;
    public $items_lost;
    public $lost_date;
    public $lost_location;
    public $description;

    protected $rules = [
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'items_lost' => 'required|string|max:255',
        'lost_date' => 'nullable|date',
        'lost_location' => 'nullable|string|max:255',
        'description' => 'required|string',
    ];

    public function render()
    {
        return view('livewire.lost-report-form');
    }

    public function submit()
    {
        $this->validate();

        if (auth()->guard('claimer')->check()) {
            $postedBy = auth()->guard('claimer')->id();
            $posterType = 'claimer';
        } elseif (Auth::check()) {
            $postedBy = Auth::id();
            $posterType = 'web';
        } else {
            $postedBy = null;
            $posterType = 'guest';
        }

        try {
            LostReport::create([
                'full_name' => $this->full_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'items_lost' => $this->items_lost,
                'lost_date' => $this->lost_date,
                'lost_location' => $this->lost_location,
                'description' => $this->description,
                'posted_by' => $postedBy,
                'poster_type' => $posterType,
                'poster_ip' => request()->ip(),
            ]);

            $this->dispatch(
                'toast-show',
                type: 'success',
                message: 'Report Submitted',
                description: 'Your lost item report has been successfully submitted'
            );

            $this->resetForm();
        } catch (\Exception $e) {
            $this->dispatch(
                'toast-show',
                type: 'danger',
                message: 'Error',
                description: 'Failed to submit report. Please try again.'
            );
        }
    }

    protected function resetForm()
    {
        $this->reset([
            'full_name',
            'email',
            'phone',
            'items_lost',
            'lost_date',
            'lost_location',
            'description'
        ]);
    }
}
