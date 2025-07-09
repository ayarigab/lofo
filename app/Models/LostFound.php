<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\ClaimedItem;
use Illuminate\Support\Str;

class LostFound extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category_id',
        'color',
        'brand',
        'model',
        'description',
        'category_id',
        'found_location',
        'found_date',
        'founder_name',
        'founder_email',
        'founder_phone',
        'founder_address',
        'image',
        'image2',
        'image3',
        'status',
        'posted_by',
        'poster_type',
        'poster_ip',
    ];

    protected $dates = ['found_date'];
    protected $casts = [
        'found_date' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeClaimed($query)
    {
        return $query->where('status', 'claimed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'archived');
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }

    public function getImage2UrlAttribute()
    {
        return $this->image2 ? asset('storage/' . $this->image2) : null;
    }

    public function getImage3UrlAttribute()
    {
        return $this->image3 ? asset('storage/' . $this->image3) : null;
    }

    public function isClaimed()
    {
        return $this->status === 'claimed';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isArchived()
    {
        return $this->status === 'archived';
    }

    public function deleteWithImage()
    {
        Storage::disk('public')->delete($this->image);
        if ($this->image2) {
            Storage::disk('public')->delete($this->image2);
        }
        if ($this->image3) {
            Storage::disk('public')->delete($this->image3);
        }
        return $this->delete();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            $item->slug = Str::slug($item->title);
        });

        static::updating(function ($item) {
            $item->slug = Str::slug($item->title);
        });
    }
}
