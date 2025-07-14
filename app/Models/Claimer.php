<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Claimer extends Authenticatable
{
    use Notifiable;

    protected $guard = 'claimer';

    protected $dates = ['dob'];
    protected $appends = ['image_url'];
    protected $casts = [
        'dob' => 'datetime',
    ];

    protected $fillable = [
        'uuid',
        'email',
        'full_name',
        'location',
        'dob',
        'phone',
        'password',
        'avatar'
    ];

    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'uuid' => 'string',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function claims()
    {
        return $this->hasMany(ClaimedItem::class);
    }

    public function getImageUrlAttribute()
    {
        return assetV("storage/$this->avatar");
    }

    public function initials(): string
    {
        return Str::of($this->full_name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
