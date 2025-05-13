<?php

namespace App\Filament\Resources\JobResource\Pages;

use App\Filament\Resources\JobResource;
use Filament\Actions;
use Illuminate\Support\Facades\DB;
use Exception;

use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model; // ✅ Add this

class EditJob extends EditRecord
{
    protected static string $resource = JobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

  protected function handleRecordUpdate(Model $record, array $data): Model
{
    try {
        DB::transaction(function () use (&$record, $data) {
        $record = parent::handleRecordUpdate($record, $data);

        if (isset($data['category_id']) && is_array($data['category_id'])) {
            $validCategoryIds = \App\Models\Category::whereIn('id', $data['category_id'])->pluck('id')->toArray();

            if (count($validCategoryIds) !== count($data['category_id'])) {
                throw new \Exception('One or more category IDs do not exist.');
            }

            $record->categories()->sync($data['category_id']);
        }
    });
        
    } catch (Exception $e ) {
        dd($e);
    }
    

    return $record;
}


}
