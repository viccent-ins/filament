<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestStudents extends BaseWidget
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
        return Student::query()
            ->latest()
            ;
    }
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->toggleable()
                ->searchable()
                ->sortable(),
            TextColumn::make('email')
                ->toggleable()
                ->searchable()
                ->sortable(),
            TextColumn::make('phone_number')
                ->toggleable(),
            TextColumn::make('class.name')
                ->sortable(),
            TextColumn::make('section.name')
                ->sortable()
                ->searchable(),
            TextColumn::make('address')
                ->wrap()
                ->searchable()
                ->toggleable()
        ];
    }
    protected function isTablePaginationEnabled(): bool
    {
        return true;
    }
//    protected function getTableRecordsPerPageSelectOptions(): ?array
//    {
//        return ['10', '20'];
//    }

}
