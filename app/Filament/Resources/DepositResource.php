<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepositResource\Pages;
use App\Models\Deposit;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class DepositResource extends Resource
{
    protected static ?string $model = Deposit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'User Information';
    public ?int $userId;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\TextInput::make('deposit_amount')->required(),
                    Forms\Components\TextInput::make('deposit_bank'),
                    Select::make('user_id')->label('User Id')->default(1)
                        ->relationship(name: 'users', titleAttribute: 'id')->reactive()
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('deposit_amount'),
                TextColumn::make('deposit_bank'),
                TextColumn::make('users.name')->label('User Name'),
                Tables\Columns\ToggleColumn::make('is_approve')->label('Is Approve')
            ])->defaultSort('created_at', 'desc')->striped()
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
//                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListDeposits::route('/'),
//            'create' => Pages\CreateDeposit::route('/create'),
//            'edit' => Pages\EditDeposit::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
//        if (auth()->user()->hasRole('Super Admin')) return true;
        return false;
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('is_approve', false); // TODO: Change the autogenerated stub
    }
}
