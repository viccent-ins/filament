<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WithdrawalResource\Pages;
use App\Filament\Resources\WithdrawalResource\RelationManagers;
use App\Models\Balance;
use App\Models\User;
use App\Models\Withdraw;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WithdrawResource extends Resource
{
    protected static ?string $model = Withdraw::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'User Information';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\TextInput::make('withdraw_amount')->required()->integer(),
                    Forms\Components\TextInput::make('withdraw_bank')->required(),
                    Select::make('user_id')
                        ->label('User Id')
                        ->relationship('users', !empty('username') ? 'username' : 'name')->preload()
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('users.username')->label('username'),
                TextColumn::make('withdraw_bank')->badge()->color('gray'),
                TextColumn::make('withdraw_amount')->money('usd')->color('primary'),
                Tables\Columns\TextColumn::make('created_at')->date('Y-m-d H:i:s'),
            ])->striped()
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Approve Withdraw')
                    ->hidden(function (Withdraw $record) {
                        if (!$record->is_approve) return false;
                        return true;
                    })
                    ->action(function (Withdraw $record) {
                        if (!$record->is_approve) {
                            // todo: add user balance assets
                            $user = User::where('id', $record->user_id)->first();
                            $user->usdt_USDT = $user->usdt_USDT - $record->withdraw_amount;
                            $user->update();
//                         //todo: record in Balance table
                            $balance = new Balance();
                            $balance->user_id = $record->user_id;
                            $balance->usdt_amount = $record->withdraw_amount;
                            $balance->usdt_prev_balance = $user->usdt_USDT;
                            $balance->approve_by = auth()->user()->username;
                            $balance->type = 'withdraw';
                            $balance->save();
                            $record->is_approve = 1;
                            $record->update();
                            Notification::make()
                                ->title('Approve Successfully!')
                                ->success()
                                ->send();
                        }
                    })
                    ->requiresConfirmation()
                    ->color('success'),
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
            'index' => Pages\ListWithdrawals::route('/'),
//            'create' => Pages\CreateWithdrawal::route('/create'),
//            'edit' => Pages\EditWithdrawal::route('/{record}/edit'),
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
            ->where('is_approve', 0)
            ->orderByRaw("is_approve - '0' asc"); // TODO: Change the autogenerated stub
    }
}
