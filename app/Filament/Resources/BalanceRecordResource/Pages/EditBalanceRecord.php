<?php

namespace App\Filament\Resources\BalanceRecordResource\Pages;

use App\Filament\Resources\BalanceRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBalanceRecord extends EditRecord
{
    protected static string $resource = BalanceRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
