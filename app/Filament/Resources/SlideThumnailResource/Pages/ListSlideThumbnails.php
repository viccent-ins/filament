<?php

namespace App\Filament\Resources\SlideThumbnailResource\Pages;

use App\Filament\Resources\SlideThumbnailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSlideThumbnails extends ListRecords
{
    protected static string $resource = SlideThumbnailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
