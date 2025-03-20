<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function job()
    {
        return $this->hasMany(Job::class);
    }
}
