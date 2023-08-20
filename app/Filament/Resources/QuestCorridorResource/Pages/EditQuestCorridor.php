<?php

namespace App\Filament\Resources\QuestCorridorResource\Pages;

use App\Filament\Resources\QuestCorridorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuestCorridor extends EditRecord
{
    protected static string $resource = QuestCorridorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
