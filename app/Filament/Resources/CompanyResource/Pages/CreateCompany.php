<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Filament\Resources\CompanyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateCompany extends CreateRecord
{
    protected static string $resource = CompanyResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug']=Str::slug($data['name']);
        return $data;
    }
}

