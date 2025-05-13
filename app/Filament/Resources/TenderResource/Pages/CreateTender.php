<?php

namespace App\Filament\Resources\TenderResource\Pages;

use App\Filament\Resources\TenderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateTender extends CreateRecord
{
    protected static string $resource = TenderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['slug']=Str::slug($data['title']).'-'.Str::random(10);
        return $data;
    }
}
