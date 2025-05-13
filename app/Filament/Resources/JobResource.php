<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobResource\Pages;
use App\Filament\Resources\JobResource\RelationManagers;
use App\Helpers\Location;
use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns([
                        'default' => 1, // Mobile: 1 column
                        'sm' => 2,      // Small screens and up: 2 columns
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('title'),
                        Forms\Components\Select::make('company_id')
                            ->options(Company::all()->pluck('name', 'id'))
                            ->label('Company'),

                        Forms\Components\Select::make('category_id')
                            ->multiple()
                            ->options(Category::all()->pluck('name', 'id'))
                            ->label('Category'),

                        Forms\Components\Select::make('location')
                            ->multiple()
                            ->options(Location::cities()),

                        Forms\Components\DatePicker::make('deadline'),

                        Forms\Components\TextInput::make('link')
                            ->url(),

                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull(), // Full width even in 2 columns

                        Forms\Components\RichEditor::make('details')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('how_to_apply')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('updated_link')

                    ]),
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
                ->color('danger'),
                Tables\Columns\ToggleColumn::make('status'),
            ])->defaultSort('created_at','desc')
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
            'index' => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'edit' => Pages\EditJob::route('/{record}/edit'),
        ];
    }
}
