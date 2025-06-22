<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimedItem extends Model
{
    public function lostFound()
    {
        return $this->belongsTo(LostFound::class);
    }
}
