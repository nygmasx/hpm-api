<?php

namespace App\Filament\Resources\CleaningStationResource\Pages;

use App\Filament\Resources\CleaningStationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCleaningStations extends ListRecords
{
    protected static string $resource = CleaningStationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
