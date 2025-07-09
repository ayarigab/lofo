<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\LostFound;
use Livewire\Component;

class LostItemSearch extends Component
{
    public string $search = '';
    public string $category = 'all';
    public bool $showResults = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => 'all']
    ];

    public function mount()
    {
        $this->showResults = true;
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'category'])) {
            $this->showResults = true;
        }
    }

    public function resetFilters()
    {
        $this->reset(['search']);
        $this->category = 'all';
        $this->showResults = true;
    }

    public function render()
    {
        $categories = Category::where('active', true)->get();

        $query = LostFound::query()->where(function($q){
            $q->where('status', '!=', 'claimed')
                ->whereNull('poster_type')
                ->orWhere('poster_type', '!=', 'guest');
        });

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%")
                    ->whereNull('poster_type')
                    ->orWhere('poster_type', '!=', 'guest')
                    ->orWhere('found_location', 'like', "%{$this->search}%")
                    ->orWhereHas('category', function ($q) {
                        $q->where('name', 'like', "%{$this->search}%");
                    });
            });
        }

        if ($this->category && $this->category !== 'all') {
            $query->where('category_id', $this->category);
        }

        $results = $this->showResults ? $query->latest()->get() : collect();

        return view('livewire.lost-item-search', [
            'results' => $results,
            'categories' => $categories
        ]);
    }
}
