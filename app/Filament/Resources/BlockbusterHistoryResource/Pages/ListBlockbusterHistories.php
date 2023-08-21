<?php

namespace App\Filament\Resources\BlockbusterHistoryResource\Pages;

use App\Filament\Resources\BlockbusterHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBlockbusterHistories extends ListRecords
{
    protected static string $resource = BlockbusterHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
