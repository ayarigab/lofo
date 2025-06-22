<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
    ];

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->message), 100);
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at ? $this->created_at->format('M j, Y \a\t g:i A') : null;
    }

    public function isLong($length = 300)
    {
        return strlen(strip_tags($this->message)) > $length;
    }
}
