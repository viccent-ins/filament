<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlideThumbnailResource\Pages;
use App\Models\SlideThumbnail;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SlideThumbnailResource extends Resource
{
    protected static ?string $model = SlideThumbnail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Home Page';
    protected static ?int $navigationSort = 1;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\TextInput::make('title')->required()->integer(),
                    Forms\Components\TextInput::make('content')->required(),
                    Forms\Components\Textarea::make('description')->required()->columnSpan(2),
                    Forms\Components\FileUpload::make('image')->required()->columnSpan(2),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('id'),
                TextColumn::make('title'),
                TextColumn::make('content'),
                TextColumn::make('description')->wrap()->limit(100)
            ])->defaultSort('created_at', 'desc')->striped()
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
            'index' => Pages\ListSlideThumbnails::route('/'),
//            'create' => Pages\CreateSlideThumbnail::route('/create'),
//            'edit' => Pages\EditSlideThumbnail::route('/{record}/edit'),
        ];
    }
}
