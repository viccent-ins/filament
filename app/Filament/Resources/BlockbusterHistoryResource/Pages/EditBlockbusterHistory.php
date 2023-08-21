<?php

namespace App\Filament\Resources\BlockbusterHistoryResource\Pages;

use App\Filament\Resources\BlockbusterHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlockbusterHistory extends EditRecord
{
    protected static string $resource = BlockbusterHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
