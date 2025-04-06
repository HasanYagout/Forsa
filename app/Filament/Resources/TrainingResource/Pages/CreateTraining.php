<?php

namespace App\Filament\Resources\TrainingResource\Pages;

use App\Filament\Resources\TrainingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CreateTraining extends CreateRecord
{
    protected static string $resource = TrainingResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug']=Str::slug($data['title']).'-'.Str::random(10);
        return $data;
    }
    protected function handleRecordCreation(array $data): Model
    {
        // Create Training model
        $training = static::getModel()::create($data);

        // Attach categories if provided
        if (isset($data['category_id']) && is_array($data['category_id'])) {
            $training->categories()->sync($data['category_id']);
        }

        return $training;
    }

}
