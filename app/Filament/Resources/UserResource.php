<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
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
                        TextInput::make('nick_name')
                            ->required()
                            ->maxLength(225),
                        TextInput::make('password')
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (Page $livewire) => $livewire instanceof  Pages\CreateUser)->password(),
                        TextInput::make('referral')
                            ->maxLength(225),
                        TextInput::make('mobile')->numeric()
                            ->maxLength(225),
                        Select::make('role')
                            ->multiple()
                            ->relationship('roles', 'name')->preload(),
                        TextInput::make('money')
                            ->numeric()
                            ->maxLength(225),
                        Radio::make('status')
                            ->required()
                            ->columnSpan(2)
                            ->options([
                                0 => 'Normal',
                                1 => 'Hidden',
                            ])
                            ->default(0)
                        ,
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable(),
                TextColumn::make('pid'),
                TextColumn::make('username')->searchable(),
                TextColumn::make('nick_name')->searchable(),
                TextColumn::make('date_of_birth'),
                TextColumn::make('mobile')->searchable(),
                TextColumn::make('created_at')->label('JoinDate'),
                TextColumn::make('incode'),
                TextColumn::make('referral')->wrap()->limit(50),
                TextColumn::make('money')
                    ->color('primary')
                    ->money('usd'),
                TextColumn::make('status')
                    ->formatStateUsing(fn (string $state): string => __($state == 0 ? 'Normal' : 'Hidden'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '0' => 'success',
                        '1' => 'danger',
                    }),
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
