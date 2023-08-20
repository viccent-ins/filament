<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnalogDataResource\Pages;
use App\Filament\Resources\AnalogDataResource\RelationManagers;
use App\Models\AnalogData;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnalogDataResource extends Resource
{
    protected static ?string $model = AnalogData::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Home Page';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        TextInput::make('member_id')->required()->maxLength(8)->minLength(6),
                        TextInput::make('profit_amount')->required(),
                        DatePicker::make('date')->format('d-m-Y')->required(),
                        FileUpload::make('image')->required(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('member_id')->sortable(),
                TextColumn::make('profit_amount')->sortable(),
                TextColumn::make('date')->sortable(),
                ImageColumn::make('image')
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
            'index' => Pages\ListAnalogData::route('/'),
//            'create' => Pages\CreateAnalogData::route('/create'),
//            'edit' => Pages\EditAnalogData::route('/{record}/edit'),
        ];
    }
}
