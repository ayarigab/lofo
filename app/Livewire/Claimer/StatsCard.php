<?php

namespace App\Livewire\Claimer;

use Livewire\Component;

class StatsCard extends Component
{

    public $title;
    public $value;
    public $icon;
    public $color;
    public $borderColor;

    public function render()
    {
        return view('livewire.claimer.stats-card');
    }
}
