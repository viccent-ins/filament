<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BalanceRecordResource\Pages;
use App\Models\Balance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BalanceRecordResource extends Resource
{
    protected static ?string $model = Balance::class;
    protected static ?string $navigationGroup = 'User Information';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                ->schema([

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('users.username'),
                TextColumn::make('usdt_amount')
                    ->money('usd')
                    ->color('primary')
                ,
                TextColumn::make('usdt_prev_amount')
                    ->money('usd')
                    ->color('warning')
                ,
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'withdraw' => 'danger',
                        'deposit' => 'success',
                    })
                ,
                TextColumn::make('created_at')->date('d-M-Y h:i:s a'),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBalanceRecords::route('/'),
//            'create' => Pages\CreateBalanceRecord::route('/create'),
//            'edit' => Pages\EditBalanceRecord::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }
}
