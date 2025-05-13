<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
    public function scopeAvailable($query)
    {

        return $query->active()->where('deadline', '>=', now());
    }
}
