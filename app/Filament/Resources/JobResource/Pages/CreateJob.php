<?php

namespace App\Filament\Resources\JobResource\Pages;

use App\Filament\Resources\JobResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CreateJob extends CreateRecord
{
    protected static string $resource = JobResource::class;

   protected function mutateFormDataBeforeCreate(array $data): array
   {
        $data['location']=json_encode($data['location']);
        $data['slug']=Str::slug($data['title']).'-'.Str::random(10);
       $data['category_id']=json_encode($data['category_id']);
       return $data;
   }
}
