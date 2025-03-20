<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function job()
    {
        return $this->hasMany(Job::class,'id','category_id');
    }
}
