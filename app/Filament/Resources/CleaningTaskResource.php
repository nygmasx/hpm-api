<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CleaningTaskResource\Pages;
use App\Filament\Resources\CleaningTaskResource\RelationManagers;
use App\Models\CleaningTask;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CleaningTaskResource extends Resource
{
    protected static ?string $model = CleaningTask::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Nettoyage';

    protected static ?string $modelLabel = 'Tâche de nettoyage';

    protected static ?string $pluralModelLabel = 'Tâches de nettoyage';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('cleaning_station_id')
                    ->relationship('cleaningStation', 'name')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\TextInput::make('estimated_time')
                    ->required(),
                Forms\Components\TextInput::make('products')
                    ->required(),
                Forms\Components\TextInput::make('products_quantity'),
                Forms\Components\TextInput::make('verification_type')
                    ->required(),
                Forms\Components\TextInput::make('temperature'),
                Forms\Components\TextInput::make('action_time'),
                Forms\Components\TextInput::make('utensil'),
                Forms\Components\TextInput::make('rinse_type'),
                Forms\Components\TextInput::make('drying_type'),
                Forms\Components\TextInput::make('frequency')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cleaningStation.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('estimated_time')
                    ->searchable(),
                Tables\Columns\TextColumn::make('products')
                    ->searchable(),
                Tables\Columns\TextColumn::make('products_quantity')
                    ->searchable(),
                Tables\Columns\TextColumn::make('verification_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('temperature')
                    ->searchable(),
                Tables\Columns\TextColumn::make('action_time')
                    ->searchable(),
                Tables\Columns\TextColumn::make('utensil')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rinse_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('drying_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('frequency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListCleaningTasks::route('/'),
            'create' => Pages\CreateCleaningTask::route('/create'),
            'edit' => Pages\EditCleaningTask::route('/{record}/edit'),
        ];
    }
}
