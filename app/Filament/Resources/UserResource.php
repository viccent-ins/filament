<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('username')
                            ->required()
                            ->maxLength(225),
                        TextInput::make('name')
                            ->maxLength(225),
                        TextInput::make('password')
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (Page $livewire) => $livewire instanceof  Pages\CreateUser)->password(),
                        TextInput::make('phone')->numeric()
                            ->maxLength(225),
                        TextInput::make('user_address'),
                        TextInput::make('email')->unique(ignoreRecord: true),
                        TextInput::make('user_level'),
                        DatePicker::make('date_of_birth')->format('Y-m-d'),
                        DateTimePicker::make('login_time'),
                        TextInput::make('score')->numeric(),
                        TextInput::make('invite_code')->unique(ignoreRecord: true)->integer()->minLength(6)->maxLength(10)->required(),
                        TextInput::make('eth_auth_amount')->integer()->default(0),
                        TextInput::make('eth_freeze_amount')->integer()->default(0),
                        TextInput::make('eth_available_quota')->integer()->default(0),
                        TextInput::make('usdt_cumulative')->integer()->default(0),
                        TextInput::make('usdt_freezing')->integer()->default(0),
                        TextInput::make('usdt_USDT')->integer()->default(0),
                        TextInput::make('eth_cumulative_income')->integer()->default(0),
                        TextInput::make('eth_today_income')->integer()->default(0),
                        TextInput::make('eth_convertible')->integer()->default(0),

                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable(),
                TextColumn::make('username')->searchable(),
                TextColumn::make('phone')->searchable(),
                TextColumn::make('date_of_birth'),
                TextColumn::make('user_address')->wrap()->limit(50),
                TextColumn::make('email'),
                TextColumn::make('user_level')->limit(40),
                TextColumn::make('login_time')->dateTime('Y-m-d H:i'),
                TextColumn::make('created_at')->label('JoinDate'),
                TextColumn::make('date_of_birth')->date('Y-m-d'),
                TextColumn::make('score'),
                TextColumn::make('invite_code'),
                TextColumn::make('eth_auth_amount')->money('usd'),
                TextColumn::make('eth_freeze_amount')->money('usd'),
                TextColumn::make('eth_available_quota')->money('usd'),
                TextColumn::make('usdt_cumulative')->money('usd'),
                TextColumn::make('usdt_USDT')->money('usd'),
                TextColumn::make('eth_cumulative_income')->money('usd'),
                TextColumn::make('eth_today_income')->money('usd'),
                TextColumn::make('eth_convertible')->money('usd'),
                TextColumn::make('email_verified_at'),
            ])
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
            'index' => Pages\ListUsers::route('/'),
//            'create' => Pages\CreateUser::route('/create'),
//            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
