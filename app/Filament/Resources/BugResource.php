<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BugResource\Pages;
use App\Filament\Resources\BugResource\RelationManagers;
use App\Models\Bug;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BugResource extends Resource
{
    protected static ?string $model = Bug::class;

    protected static ?string $navigationIcon = 'heroicon-o-bug-ant';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                ->disabled(),
                TextInput::make('last_name')
                ->disabled(),
                TextInput::make('email')
                    ->email()
                ->disabled(),
                textarea::make('message')
                ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label('name')
                ->formatStateUsing(function ($record,$state) {
                   return $record->first_name.' '.$record->last_name;
                }),
                TextColumn::make('email'),
                TextColumn::make('message')
                ->wrap(),
                TextColumn::make('type')
                    ->badge()
                    ->wrap(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBugs::route('/'),
            'create' => Pages\CreateBug::route('/create'),
            'edit' => Pages\EditBug::route('/{record}/edit'),
        ];
    }
}
