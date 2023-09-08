<?php

namespace App\Filament\Resources\PurchasingProductResource\Pages;

use App\Filament\Resources\PurchasingProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchasingProduct extends EditRecord
{
    protected static string $resource = PurchasingProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
