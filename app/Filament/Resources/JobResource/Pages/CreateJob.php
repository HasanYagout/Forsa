<?php

namespace App\Filament\Resources\JobResource\Pages;

use App\Filament\Resources\JobResource;
use App\Models\Category;
use App\Models\Job;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CreateJob extends CreateRecord
{
    protected static string $resource = JobResource::class;

   protected function mutateFormDataBeforeCreate(array $data): array
   {
        $data['slug']=Str::slug($data['title']).'-'.Str::random(10);

       return $data;
   }
    protected function handleRecordCreation(array $data): Model
    {
        // Create Training model
        $job = static::getModel()::create($data);

        // Attach categories if provided
        if (isset($data['category_id']) && is_array($data['category_id'])) {
            $job->categories()->sync($data['category_id']);
        }

        return $job;
    }
}
