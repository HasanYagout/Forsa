<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TenderResource\Pages;
use App\Filament\Resources\TenderResource\RelationManagers;
use App\Models\Category;
use App\Models\Company;
use App\Models\Tender;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TenderResource extends Resource
{
    protected static ?string $model = Tender::class;

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
                    Forms\Components\Select::make('location')
                        ->multiple()
                        ->options(self::$model::LOCATIONS),
                    Forms\Components\DatePicker::make('deadline'),
                    Forms\Components\Textarea::make('description')
                    ->columnSpan(2),
                    Forms\Components\RichEditor::make('details')
                        ->columnSpan(2),
                    Forms\Components\FileUpload::make('files')
                        ->acceptedFileTypes(['application/pdf'])
                        ->label('Upload PDF Files')
                        ->preserveFilenames()
                        ->directory('tenders')
                        ->multiple()
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
                TextColumn::make('location')
                ->badge(),
                TextColumn::make('company.name'),
                TextColumn::make('created_at')
                    ->label('posted at'),
                TextColumn::make('deadline')
                    ->color('danger'),
                ToggleColumn::make('status')
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
            'index' => Pages\ListTenders::route('/'),
            'create' => Pages\CreateTender::route('/create'),
            'edit' => Pages\EditTender::route('/{record}/edit'),
        ];
    }
}
