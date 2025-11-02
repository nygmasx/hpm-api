<?php

namespace App\Filament\Resources\CleaningZoneResource\Pages;

use App\Filament\Resources\CleaningZoneResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCleaningZone extends EditRecord
{
    protected static string $resource = CleaningZoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
