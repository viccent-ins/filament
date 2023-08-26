<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepositResource\Pages;
use App\Models\Assets\Balance;
use App\Models\Deposit;
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
                        ->relationship(name: 'users', titleAttribute: 'nick_name')->preload()
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('deposit_amount')->money('usd'),
                TextColumn::make('deposit_bank'),
                TextColumn::make('users.nick_name')->label('User Nick Name'),
            ])->defaultSort('created_at', 'desc')->striped()
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Approve Balance')
                    ->action(function (Deposit $record) {
                       if (!$record->is_approve) {
                           // todo: add user balance assets
                           $balance = Balance::where('user_id', $record->user_id)->first();
                           if (is_null($balance)) {
                               $balanceId = Balance::insertGetId([
                                  'user_id' =>$record->user_id,
                                  'assets_balance' => 0
                               ]);
                               Balance::where('id', $balanceId)->update([
                                   'assets_balance' => $record->deposit_amount,
                               ]);
                           } else {
                               Balance::where('user_id', $record->user_id)->update([
                                   'assets_balance' => $balance->assets_balance + $record->deposit_amount,
                               ]);
                           }
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
