<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CleaningZoneResource\Pages;
use App\Filament\Resources\CleaningZoneResource\RelationManagers;
use App\Models\CleaningZone;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CleaningZoneResource extends Resource
{
    protected static ?string $model = CleaningZone::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Nettoyage';

    protected static ?string $modelLabel = 'Zone de nettoyage';

    protected static ?string $pluralModelLabel = 'Zones de nettoyage';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
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
            'index' => Pages\ListCleaningZones::route('/'),
            'create' => Pages\CreateCleaningZone::route('/create'),
            'edit' => Pages\EditCleaningZone::route('/{record}/edit'),
        ];
    }
}
