<?php

namespace App\Filament\Resources\CleaningZoneResource\Pages;

use App\Filament\Resources\CleaningZoneResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCleaningZones extends ListRecords
{
    protected static string $resource = CleaningZoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
