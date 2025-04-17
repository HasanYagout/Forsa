<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    protected $table = 'job';
    protected $casts = [
        'category_id' => 'array',
        'location' => 'array',
        'deadline' => 'date',  // or 'datetime' if it includes time

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
    public function getCategoryNamesAttribute()
    {
        $categoryIds = $this->category_id; // Already cast to an array
        return Category::whereIn('id', $categoryIds)->pluck('name')->toArray();
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
    public function bookmarkedBy()
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }
}
