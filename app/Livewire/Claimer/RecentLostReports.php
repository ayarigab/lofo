<?php

namespace App\Livewire\Claimer;

use Livewire\Component;
use App\Models\LostReport;

class RecentLostReports extends Component
{
    public $limit;
    public function render()
    {
        $reports = LostReport::where('posted_by', auth('claimer')->id())
            ->where('poster_type', 'claimer')
            ->latest()
            ->take($this->limit)
            ->get();

        return view('livewire.claimer.recent-lost-reports', [
            'reports' => $reports
        ]);
    }
}
