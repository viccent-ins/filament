<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewArrivalResource\Pages;
use App\Filament\Resources\NewArrivalResource\RelationManagers;
use App\Models\NewArrival;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewArrivalResource extends Resource
{
    protected static ?string $model = NewArrival::class;

    protected static ?string $navigationGroup = 'Detail Page';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\TextInput::make('title')->required(),
                    Forms\Components\TextInput::make('star')->integer()->required()->minValue(1)->maxValue(5),
                    Forms\Components\DatePicker::make('date_arrival')->required(),
                    Forms\Components\TextInput::make('minute')->required()->minLength(1)->maxLength(3)->numeric(),
                    Forms\Components\RichEditor::make('summery'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('star'),
                TextColumn::make('date_arrival')->date(),
                TextColumn::make('minute'),
                TextColumn::make('summery')->limit(50),
                TextColumn::make('created_at'),
            ])
            ->filters([

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
            'index' => Pages\ListNewArrivals::route('/'),
//            'create' => Pages\CreateNewArrival::route('/create'),
//            'edit' => Pages\EditNewArrival::route('/{record}/edit'),
        ];
    }
}
