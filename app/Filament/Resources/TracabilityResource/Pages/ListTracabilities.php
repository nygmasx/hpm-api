<?php

namespace App\Filament\Resources\TracabilityResource\Pages;

use App\Filament\Resources\TracabilityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTracabilities extends ListRecords
{
    protected static string $resource = TracabilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
