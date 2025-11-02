<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TracabilityResource\Pages;
use App\Filament\Resources\TracabilityResource\RelationManagers;
use App\Models\Tracability;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TracabilityResource extends Resource
{
    protected static ?string $model = Tracability::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';

    protected static ?string $navigationGroup = 'Production';

    protected static ?string $modelLabel = 'Traçabilité';

    protected static ?string $pluralModelLabel = 'Traçabilités';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\DateTimePicker::make('opened_at'),
                Forms\Components\TextInput::make('service'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('opened_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('service')
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
            'index' => Pages\ListTracabilities::route('/'),
            'create' => Pages\CreateTracability::route('/create'),
            'edit' => Pages\EditTracability::route('/{record}/edit'),
        ];
    }
}
