<?php

namespace App\Filament\Resources\QuestCorridorResource\Pages;

use App\Filament\Resources\QuestCorridorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuestCorridors extends ListRecords
{
    protected static string $resource = QuestCorridorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
