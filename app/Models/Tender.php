<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    protected $table = 'tenders';
    protected $casts = [
        'category_id' => 'array',
        'location' => 'array',
        'deadline' => 'date',
    ];
    const LOCATIONS=[
        "Sana'a"=>"Sana'a",
        'Aden'=>'Aden',
        'Taiz'=>'Taiz',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function bookmarkedBy()
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }
}
