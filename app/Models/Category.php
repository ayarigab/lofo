<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'active'];
    public function lostFounds()
    {
        return $this->hasMany(LostFound::class);
    }

    public function scopeActive()
    {
        return $this->where('active', true);
    }
    public function scopeInactive()
    {
        return $this->where('active', false);
    }
    public function claimedItems()
    {
        return $this->hasMany(ClaimedItem::class);
    }
}
