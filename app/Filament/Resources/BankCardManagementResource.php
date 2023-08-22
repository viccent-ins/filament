<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankCardManagementResource\Pages;
use App\Filament\Resources\BankCardManagementResource\RelationManagers;
use App\Models\BankCardManagement;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BankCardManagementResource extends Resource
{
    protected static ?string $model = BankCardManagement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'User Information';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('card_real_name')->required()->maxLength(225),
                    TextInput::make('card_address')->required(),
                    TextInput::make('card_address_2')->required(),
                    Select::make('user_id')
                        ->relationship(name: 'users', titleAttribute: 'name')->required(),
                    TextInput::make('others'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('card_real_name'),
                TextColumn::make('card_address'),
                TextColumn::make('users.name')->label('User Name'),
                TextColumn::make('created_at')->label('Installed At')->date('y-M-D'),
                TextColumn::make('other'),
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
            'index' => Pages\ListBankCardManagement::route('/'),
//            'create' => Pages\CreateBankCardManagement::route('/create'),
//            'edit' => Pages\EditBankCardManagement::route('/{record}/edit'),
        ];
    }
}
