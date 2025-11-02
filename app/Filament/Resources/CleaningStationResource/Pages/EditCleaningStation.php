<?php

namespace App\Filament\Resources\CleaningStationResource\Pages;

use App\Filament\Resources\CleaningStationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCleaningStation extends EditRecord
{
    protected static string $resource = CleaningStationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
