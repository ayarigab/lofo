<?php

namespace App\Livewire\Claimer;

use Livewire\Component;
use App\Models\LostReport;
use App\Models\LostFound;

class PotentialMatches extends Component
{
    public function render()
    {
        $userReports = LostReport::where('posted_by', auth('claimer')->id())
            ->where('poster_type', 'claimer')
            ->pluck('items_lost');

        $matches = LostFound::whereIn('title', $userReports)
            ->orWhere(function ($query) use ($userReports) {
                foreach ($userReports as $report) {
                    $query->orWhere('title', 'like', "%{$report}%");
                }
            })
            ->where('status', '!=', 'claimed')
            ->take(4)
            ->get();

        return view('livewire.claimer.potential-matches', [
            'matches' => $matches
        ]);
    }
}
