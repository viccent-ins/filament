<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlockbusterHistoryResource\Pages;
use App\Filament\Resources\BlockbusterHistoryResource\RelationManagers;
use App\Models\BlockbusterHistory;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlockbusterHistoryResource extends Resource
{
    protected static ?string $model = BlockbusterHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Detail Page';
    protected static ?int $navigationSort = 3;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    TextInput::make('title')->maxLength(225),
                    Forms\Components\RichEditor::make('description'),
                    Forms\Components\DatePicker::make('date_end'),
                    FileUpload::make('image'),
                    TextInput::make('amount_people')->integer(),
                    TextInput::make('other')->integer(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('title')->limit(15)->wrap(),
                Tables\Columns\TextColumn::make('description')->limit(20)->wrap(),
                Tables\Columns\TextColumn::make('date_end')->date(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
                Tables\Columns\TextColumn::make('other'),
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
            'index' => Pages\ListBlockbusterHistories::route('/'),
//            'create' => Pages\CreateBlockbusterHistory::route('/create'),
//            'edit' => Pages\EditBlockbusterHistory::route('/{record}/edit'),
        ];
    }
}
