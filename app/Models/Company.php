<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function job()
    {
        return $this->hasMany(Job::class);
    }
    protected static function booted()
    {
        static::updated(function ($company) {
            // Only proceed if status has changed
            if ($company->isDirty('status')) {
                $newStatus = $company->status;
                $company->job()->update(['status' => $newStatus]);
                $company->tenders()->update(['status' => $newStatus]);
                $company->trainings()->update(['status' => $newStatus]);
            }
        });
    }


    public function tenders()
    {
        return $this->hasMany(Tender::class);

    }
    public function trainings()
    {
        return $this->hasMany(Training::class);

    }
}
