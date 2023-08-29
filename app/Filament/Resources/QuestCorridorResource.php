<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestCorridorResource\Pages;
use App\Filament\Resources\QuestCorridorResource\RelationManagers;
use App\Models\QuestCorridor;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuestCorridorResource extends Resource
{
    protected static ?string $model = QuestCorridor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Home Page';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('price')->required(),
                    TextInput::make('percentage')->required(),
                    TextInput::make('turn')->required(),
                    FileUpload::make('image')->required()
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                ImageColumn::make('image')->sortable(),
                TextColumn::make('name')->sortable(),
                TextColumn::make('price')
                    ->money('usd')
                    ->sortable(),
                TextColumn::make('turn')->sortable(),
                TextColumn::make('percentage')->sortable(),
                TextColumn::make('created_at')->sortable(),
            ])->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListQuestCorridors::route('/'),
//            'create' => Pages\CreateQuestCorridor::route('/create'),
//            'edit' => Pages\EditQuestCorridor::route('/{record}/edit'),
        ];
    }
}
