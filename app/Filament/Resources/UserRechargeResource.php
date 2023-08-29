<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserRechargeResource\Pages;
use App\Models\UserRecharge;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserRechargeResource extends Resource
{
    protected static ?string $model = UserRecharge::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationGroup = 'User Information';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Select::make('user_id')->label('Username')
                        ->relationship('users', !empty('username') ? 'username' : 'nick_name')
                        ->preload(),
                    Forms\Components\TextInput::make('order_id')->label('Product Id'),
                    TextInput::make('refusal_reason_remark')->maxLength(225),
                    Forms\Components\TextInput::make('order_status')->numeric(),
                    Forms\Components\TextInput::make('order_remark')->integer(),
                    Forms\Components\TextInput::make('order_creation_time')->integer(),
                    Forms\Components\TextInput::make('order_approval_time'),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                ImageColumn::make('order_id')->sortable(),
                TextColumn::make('user_id')->sortable(),
                TextColumn::make('refusal_reason_remark')->sortable(),
                TextColumn::make('order_status')->sortable(),
                TextColumn::make('order_remark')->sortable(),
                TextColumn::make('order_creation_time')->sortable(),
                TextColumn::make('order_approval_time')->sortable(),
                TextColumn::make('created_at')->sortable(),
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
            'index' => Pages\ListUserRecharges::route('/'),
            'create' => Pages\CreateUserRecharge::route('/create'),
            'edit' => Pages\EditUserRecharge::route('/{record}/edit'),
        ];
    }
}
