<?php

namespace App\Filament\Resources\OilTrayResource\Pages;

use App\Filament\Resources\OilTrayResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOilTray extends EditRecord
{
    protected static string $resource = OilTrayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
