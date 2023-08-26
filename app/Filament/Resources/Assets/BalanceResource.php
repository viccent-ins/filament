<?php

namespace App\Filament\Resources\Assets;

use App\Filament\Resources\Assets\BalanceResource\Pages;
use App\Models\Assets\Balance;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BalanceResource extends Resource
{
    protected static ?string $model = Balance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'User Information';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('assets_balance')->numeric()
                        ->maxLength(10)
                        ->required(),
//                    Select::make('user_id')
//                        ->required()
//                        ->label('User Nick Name')
//                        ->relationship(name: 'users', titleAttribute: 'nick_name')
//                        ->preload()
//                    ,
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id'),
                TextColumn::make('assets_balance')->money('usd'),
                TextColumn::make('users.name'),
                TextColumn::make('created_at')->dateTime('d-M-Y h:i A'),
            ])
            ->striped()
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBalances::route('/'),
//            'create' => Pages\CreateBalance::route('/create'),
//            'edit' => Pages\EditBalance::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }
}
