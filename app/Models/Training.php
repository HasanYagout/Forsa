<?php

namespace App\Models;

use App\Observers\TrainingObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
#[ObservedBy([TrainingObserver::class])]

class Training extends Model
{
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
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_training');
    }
    public function getCategoryNamesAttribute()
    {
        $categoryIds = $this->category_id; // Already cast to an array
        return Category::whereIn('id', $categoryIds)->pluck('name')->toArray();
    }
    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }

}
