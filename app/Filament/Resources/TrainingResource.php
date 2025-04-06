<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingResource\Pages;
use App\Filament\Resources\TrainingResource\RelationManagers;
use App\Models\Category;
use App\Models\Company;
use App\Models\Training;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrainingResource extends Resource
{
    protected static ?string $model = Training::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('title'),
                    Forms\Components\Select::make('company_id')
                        ->options(Company::all()->pluck('name', 'id'))
                        ->label('company'),
                    Forms\Components\Select::make('category_id')
                        ->multiple()
                        ->options(Category::all()->pluck('name', 'id'))
                        ->label('category'),
                    Forms\Components\Select::make('location')
                        ->multiple()
                        ->options(self::$model::LOCATIONS),
                    Forms\Components\DatePicker::make('deadline'),
                    Forms\Components\Textarea::make('description'),
                    Forms\Components\TextInput::make('link')
                        ->url(),
                    Forms\Components\RichEditor::make('details')
                        ->columnSpan(2),
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('company.logo')
                    ->circular(),
                TextColumn::make('title'),
                TextColumn::make('category_names')
                    ->label('Categories')
                    ->formatStateUsing(fn ($state) => $state) // $state is now an array
                    ->badge() // Display each item as a badge
                    ->listWithLineBreaks() // Display badges in a vertical list
                    ->sortable() // Make the column sortable
                    ->searchable(), // Make the column searchable
                TextColumn::make('company.name'),
                TextColumn::make('created_at')
                    ->label('posted at'),
                TextColumn::make('deadline')
                    ->color('danger')
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
            'index' => Pages\ListTrainings::route('/'),
            'create' => Pages\CreateTraining::route('/create'),
            'edit' => Pages\EditTraining::route('/{record}/edit'),
        ];
    }
}
