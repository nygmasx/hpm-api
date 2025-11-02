<?php

namespace App\Filament\Resources\CleaningPlanResource\Pages;

use App\Filament\Resources\CleaningPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCleaningPlans extends ListRecords
{
    protected static string $resource = CleaningPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
