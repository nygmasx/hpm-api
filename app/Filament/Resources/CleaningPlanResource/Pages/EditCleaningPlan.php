<?php

namespace App\Filament\Resources\CleaningPlanResource\Pages;

use App\Filament\Resources\CleaningPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCleaningPlan extends EditRecord
{
    protected static string $resource = CleaningPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
