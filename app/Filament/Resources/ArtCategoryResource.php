<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtCategoryResource\Pages;
use App\Filament\Resources\ArtCategoryResource\RelationManagers;
use App\Models\ArtCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArtCategoryResource extends Resource
{
    protected static ?string $model = ArtCategory::class;
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Shop';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('art_level')->string()->required(),
                        Forms\Components\TextInput::make('art_other')->nullable()->label('Art Other (Optional)'),
                        Forms\Components\TextInput::make('art_price_start')->numeric()->required(),
                        Forms\Components\TextInput::make('art_price_end')->numeric()->required(),
                        Forms\Components\TextInput::make('art_coin_type')->required(),
                        Forms\Components\FileUpload::make('art_image')->required()->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\ImageColumn::make('art_image'),
                Tables\Columns\TextColumn::make('art_level')->searchable(),
                Tables\Columns\TextColumn::make('art_price_start')->color('primary')->searchable(),
                Tables\Columns\TextColumn::make('art_price_end')->color('primary')->searchable(),
                Tables\Columns\TextColumn::make('art_coin_type')->badge()->color('warning'),
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
            'index' => Pages\ListArtCategories::route('/'),
//            'create' => Pages\CreateArtCategory::route('/create'),
//            'edit' => Pages\EditArtCategory::route('/{record}/edit'),
        ];
    }
}
