<?php

namespace App\Filament\Resources\SlideThumbnailResource\Pages;

use App\Filament\Resources\SlideThumbnailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSlideThumbnail extends EditRecord
{
    protected static string $resource = SlideThumbnailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
