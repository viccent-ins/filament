<?php

namespace App\Filament\Resources\Assets;

use App\Filament\Resources\Assets\ProfitResource\Pages;
use App\Models\Assets\Profit;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProfitResource extends Resource
{
    protected static ?string $model = Profit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'User Information';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    TextInput::make('asset_profit')
                        ->numeric()
                        ->label('Profit of the day')
                        ->maxLength(225)->required(),
                    Select::make('user_id')
                        ->label('User Nick Name')
                        ->relationship(name: 'users', titleAttribute: 'nick_name')
                        ->preload()
                    ,
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('assets_profit'),
                TextColumn::make('users.name'),
                TextColumn::make('created_at')->dateTime('d-M-Y h:i A'),
                TextColumn::make('created_at'),
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
            'index' => Pages\ListProfits::route('/'),
//            'create' => Pages\CreateProfit::route('/create'),
//            'edit' => Pages\EditProfit::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }
}
