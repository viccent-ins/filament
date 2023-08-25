<?php

namespace App\Filament\Resources\Assets\ProfitResource\Pages;

use App\Filament\Resources\Assets\ProfitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfits extends ListRecords
{
    protected static string $resource = ProfitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
