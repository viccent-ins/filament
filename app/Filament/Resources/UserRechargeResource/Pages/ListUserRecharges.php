<?php

namespace App\Filament\Resources\UserRechargeResource\Pages;

use App\Filament\Resources\UserRechargeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserRecharges extends ListRecords
{
    protected static string $resource = UserRechargeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
