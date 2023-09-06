<?php

namespace App\Filament\Resources\NftProductResource\Pages;

use App\Filament\Resources\NftProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNftProducts extends ListRecords
{
    protected static string $resource = NftProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
