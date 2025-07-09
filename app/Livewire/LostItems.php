<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LostFound;
use App\Models\Category;

class LostItems extends Component
{
    use WithPagination;

    public $search = '';
    public $category = 'all';
    public $status = [];
    public $loading = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => 'all'],
        'status' => ['except' => []]
    ];

    public function paginationView()
    {
        return 'vendor.livewire.tailwind';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'category', 'status']);
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::where('active', true)->get();

        $query = LostFound::query()
            ->with('category')
            ->where(function ($q) {
                $q->whereNull('poster_type')
                    ->orWhere('poster_type', '!=', 'guest');
            })
            ->latest();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%")
                    ->orWhere('found_location', 'like', "%{$this->search}%")
                    ->orWhereHas('category', function($q) {
                        $q->where('name', 'like', "%{$this->search}%");
                });
            });
        }

        if ($this->category !== 'all') {
            $query->where('category_id', $this->category);
        }

        if (!empty($this->status)) {
            $query->whereIn('status', $this->status);
        }

        $lostItems = $query->paginate(12);

        return view('livewire.lost-items', [
            'lostItems' => $lostItems,
            'categories' => $categories
        ]);
    }
}
