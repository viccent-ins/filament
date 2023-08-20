<?php

namespace App\Filament\Resources\AnalogDataResource\Pages;

use App\Filament\Resources\AnalogDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnalogData extends ListRecords
{
    protected static string $resource = AnalogDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
