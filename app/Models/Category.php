<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class, 'category_training');
    }
}
