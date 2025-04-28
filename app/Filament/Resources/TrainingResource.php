<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingResource\Pages;
use App\Filament\Resources\TrainingResource\RelationManagers;
use App\Helpers\Location;
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
                        Forms\Components\DatePicker::make('deadline')
                        ->date(),
                        Forms\Components\TextInput::make('link')
                            ->url(),
                        Forms\Components\Textarea::make('description'),
                        Forms\Components\TextInput::make('price')
                            ->numeric(),
                        Forms\Components\RichEditor::make('details')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('how_to_apply')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('image')
                            ->directory('trainings')
                            ->columnSpanFull(),
                    ]),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->hasRole('training')){
                return $query->with('company')->where('added_by', auth()->id())->orderBy('created_at', 'desc');
                }
                else
                    return $query->orderBy('created_at', 'desc');
            })
            ->columns([
                Tables\Columns\ImageColumn::make('company.logo')
                    ->circular(),
                TextColumn::make('title'),
                TextColumn::make('price'),
                TextColumn::make('company.name'),
                TextColumn::make('created_at')
                    ->label('posted at'),
                TextColumn::make('deadline')
                    ->color('danger'),
                Tables\Columns\ToggleColumn::make('status')
                ->hidden(auth()->user()->hasRole('training'))
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
