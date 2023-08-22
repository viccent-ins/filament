<?php

namespace App\Filament\Resources\BankCardManagementResource\Pages;

use App\Filament\Resources\BankCardManagementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBankCardManagement extends ListRecords
{
    protected static string $resource = BankCardManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
