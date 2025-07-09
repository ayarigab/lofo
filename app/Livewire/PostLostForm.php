<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\LostFound;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostLostForm extends Component
{
    use WithFileUploads;

    public $category_id;
    public $title;
    public $brand;
    public $color;
    public $model;
    public $description;
    public $found_location;
    public $found_date;
    public $founder_name;
    public $founder_email;
    public $founder_phone;
    public $founder_address;
    public $image;
    public $image2;
    public $image3;

    public $previewImage;
    public $previewImage2;
    public $previewImage3;

    public $additionalImages = [];

    protected $rules = [
        'category_id' => 'required|exists:categories,id',
        'title' => 'required|string|max:255',
        'brand' => 'nullable|string|max:255',
        'color' => 'nullable|string|max:255',
        'model' => 'nullable|string|max:255',
        'description' => 'required|string',
        'found_location' => 'nullable|string|max:255',
        'found_date' => 'nullable|date',
        'founder_name' => 'required|string|max:255',
        'founder_email' => 'nullable|email|max:255',
        'founder_phone' => 'required|string|max:20',
        'founder_address' => 'nullable|string|max:255',
        'image' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        'image2' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        'image3' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
    ];

    protected $listeners = ['refreshImages' => '$refresh'];

    public function render()
    {
        return view('livewire.post-lost-form', [
            'categories' => Category::where('active', true)->get()
        ]);
    }

    public function updatedImage()
    {
        $this->validateOnly('image');
        $this->previewImage = $this->image->temporaryUrl();
    }

    public function updatedImage2()
    {
        $this->validateOnly('image2');
        $this->previewImage2 = $this->image2->temporaryUrl();
    }

    public function updatedImage3()
    {
        $this->validateOnly('image3');
        $this->previewImage3 = $this->image3->temporaryUrl();
    }

    public function addAdditionalImage()
    {
        if (count($this->additionalImages) < 2) {
            $this->additionalImages[] = [
                'id' => uniqid(),
                'field' => count($this->additionalImages) === 0 ? 'image2' : 'image3'
            ];
        }
    }

    public function removeAdditionalImage($index)
    {
        if ($this->additionalImages[$index]['field'] === 'image2') {
            $this->image2 = null;
            $this->previewImage2 = null;
        } else {
            $this->image3 = null;
            $this->previewImage3 = null;
        }
        unset($this->additionalImages[$index]);
        $this->additionalImages = array_values($this->additionalImages);
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
            $imagePath = $this->image->store('', 'public');


            $data = [
                'category_id' => $this->category_id,
                'title' => $this->title,
                'brand' => $this->brand,
                'color' => $this->color,
                'model' => $this->model,
                'description' => $this->description,
                'found_location' => $this->found_location,
                'found_date' => $this->found_date,
                'founder_name' => $this->founder_name,
                'founder_email' => $this->founder_email,
                'founder_phone' => $this->founder_phone,
                'founder_address' => $this->founder_address,
                'image' => $imagePath,
                'status' => 'pending',
                'posted_by' => $postedBy,
                'poster_type' => $posterType,
                'poster_ip' => request()->ip(),
            ];

            if ($this->image2) {
                $data['image2'] = $this->image2->store('', 'public');
            }

            if ($this->image3) {
                $data['image3'] = $this->image3->store('', 'public');
            }

            LostFound::create($data);

            $this->dispatch('toast-show', [
                'data' => [
                    'type' => 'success',
                    'message' => 'Success!',
                    'description' => 'Item has been successfully reported.'
                ]
            ]);

            $this->resetForm();
        } catch (\Exception $e) {
            $this->dispatch('toast-show', [
                'data' => [
                    'type' => 'danger',
                    'message' => 'Error!',
                    'description' => 'An error occurred: ' . $e->getMessage()
                ]
            ]);
        }
    }

    protected function resetForm()
    {
        $this->reset([
            'category_id',
            'title',
            'brand',
            'color',
            'model',
            'description',
            'found_location',
            'found_date',
            'founder_name',
            'founder_email',
            'founder_phone',
            'founder_address',
            'image',
            'image2',
            'image3',
            'previewImage',
            'previewImage2',
            'previewImage3',
            'additionalImages'
        ]);
    }
}
