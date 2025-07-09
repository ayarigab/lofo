<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LostReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'items_lost',
        'lost_date',
        'lost_location',
        'description',
        'posted_by',
        'poster_type',
        'poster_ip',
    ];

    protected $casts = [
        'lost_date' => 'datetime',
    ];

    protected $dates = ['lost_date'];

    public function scopeRecent($query)
    {
        return $query->where('lost_date', '>=', now()->subDays(30));
    }

    public function scopeItemLike($query, $item)
    {
        return $query->where('items_lost', 'like', '%' . $item . '%');
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/\D/', '', $value); // strip non-digits
    }

    public function getFormattedLostDateAttribute()
    {
        return $this->lost_date ? \Carbon\Carbon::parse($this->lost_date)->format('F j, Y') : 'Unknown';
    }

    public function isComplete()
    {
        return $this->full_name && $this->email && $this->items_lost && $this->lost_date;
    }
}
