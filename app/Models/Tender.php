<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    const LOCATIONS=[
        "Sana'a"=>"Sana'a",
        'Aden'=>'Aden'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
