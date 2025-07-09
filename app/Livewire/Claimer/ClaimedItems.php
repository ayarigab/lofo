<?php

namespace App\Livewire\Claimer;

use Livewire\Component;
use App\Models\ClaimedItem;

class ClaimedItems extends Component
{
    public $limit;
    public function render()
    {
        $items = ClaimedItem::with('lostFound')
            ->where('claimer_id', auth('claimer')->id())
            ->latest()
            ->take($this->limit)
            ->get();
        return view('livewire.claimer.claimed-items', [
            'items' => $items
        ]);
    }
}
