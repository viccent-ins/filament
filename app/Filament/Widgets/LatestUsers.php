<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestUsers extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

//    public function table(Table $table): Table
//    {
//        return $table
//            ->query(
//                // ...
//            )
//            ->columns([
//                // ...
//            ]);
//    }
    protected function getTableQuery(): Builder
    {
        return User::query()
            ->latest();
    }
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->toggleable(),
            TextColumn::make('pid')
                ->toggleable(),
            TextColumn::make('username')
                ->toggleable()
                ->searchable()
                ->sortable(),
            TextColumn::make('email')
                ->toggleable(),
            TextColumn::make('mobile')
                ->toggleable(),
            TextColumn::make('incode')
                ->toggleable(),
            TextColumn::make('pid')
                ->toggleable(),
            TextColumn::make('created_at')
                ->toggleable(),
        ];
    }
    protected function isTablePaginationEnabled(): bool
    {
        return true;
    }
    protected function getTableRecordsPerPageSelectOptions(): ?array
    {
        return ['10', '25', '50', '50', '100'];
    }

}
