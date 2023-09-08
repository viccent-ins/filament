<?php

namespace App\Filament\Resources\PurchasingProductResource\Pages;

use App\Filament\Resources\PurchasingProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchasingProducts extends ListRecords
{
    protected static string $resource = PurchasingProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
