<?php

namespace App\Filament\Resources\BugResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBug extends CreateRecord
{
    protected static string $resource = ContactResource::class;
}
