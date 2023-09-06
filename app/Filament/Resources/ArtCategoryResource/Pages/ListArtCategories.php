<?php

namespace App\Filament\Resources\ArtCategoryResource\Pages;

use App\Filament\Resources\ArtCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtCategories extends ListRecords
{
    protected static string $resource = ArtCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
