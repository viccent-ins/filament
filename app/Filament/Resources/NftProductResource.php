<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NftProductResource\Pages;
use App\Filament\Resources\NftProductResource\RelationManagers;
use App\Models\NftProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NftProductResource extends Resource
{
    protected static ?string $model = NftProduct::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Shop';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('nft_title')
                        ->required(),
                    Forms\Components\Select::make('art_id')
                        ->label('Art Category')
                        ->relationship('artCategories', 'art_level')
                        ->required(),
                    Forms\Components\Select::make('user_id')
                        ->label('User Name')
                        ->relationship('users', 'username')
                        ->required(),
                    Forms\Components\TextInput::make('nft_like')
                        ->default(0)
                        ->integer(),
                    Forms\Components\TextInput::make('nft_price')
                        ->numeric(),
                    Forms\Components\TextInput::make('nft_coin_type')->string(),
                    Forms\Components\TextInput::make('art_other')
                        ->nullable(),
                    Forms\Components\FileUpload::make('nft_image')->columnSpanFull()
                        ->required()
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\ImageColumn::make('nft_image'),
                Tables\Columns\TextColumn::make('artCategories.art_level')->color('success')->searchable(),
                Tables\Columns\TextColumn::make('nft_title')->searchable(),
                Tables\Columns\TextColumn::make('nft_like'),
                Tables\Columns\TextColumn::make('nft_love'),
                Tables\Columns\TextColumn::make('nft_price')->color('primary'),
                Tables\Columns\TextColumn::make('nft_coin_type')->badge()->color('warning'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('Y-m-m H:i:s'),
            ])->defaultSort('created_at','desc')
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
            'index' => Pages\ListNftProducts::route('/'),
//            'create' => Pages\CreateNftProduct::route('/create'),
//            'edit' => Pages\EditNftProduct::route('/{record}/edit'),
        ];
    }
}
