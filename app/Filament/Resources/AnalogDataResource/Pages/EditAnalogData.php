<?php

namespace App\Filament\Resources\AnalogDataResource\Pages;

use App\Filament\Resources\AnalogDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnalogData extends EditRecord
{
    protected static string $resource = AnalogDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
