<?php

namespace App\Filament\Resources\CooperativeFilmResource\Pages;

use App\Filament\Resources\CooperativeFilmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCooperativeFilms extends ListRecords
{
    protected static string $resource = CooperativeFilmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
