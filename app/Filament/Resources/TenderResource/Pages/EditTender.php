<?php

namespace App\Filament\Resources\TenderResource\Pages;

use App\Filament\Resources\TenderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTender extends EditRecord
{
    protected static string $resource = TenderResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($this->record && $this->record->files) {
            foreach ($this->record->files as $file) {
                \Storage::disk('public')->delete('tenders/' . $file);
            }
        }

        return $data;
    }



    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
