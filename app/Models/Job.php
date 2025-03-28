<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'job';
    protected $casts = [
        'category_id' => 'array',
        'location' => 'array',
    ];
    const LOCATIONS=[
        "Sana'a"=>"Sana'a",
        'Aden'=>'Aden'
    ];
    const TYPES=[
        'Full Time'=>'Full Time',
        'Part Time'=>'Part Time',
        'Contract'=>'Contract',
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
}
