<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvestmentResource\Pages;
use App\Filament\Resources\InvestmentResource\RelationManagers;
use App\Models\Investment;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvestmentResource extends Resource
{
    protected static ?string $model = Investment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Detail Page';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    TextInput::make('gmg_name')->maxLength(225),
                    Forms\Components\TextInput::make('gmg_percentage')->numeric(),
                    Forms\Components\TextInput::make('gmg_increase_stock')->integer(),
                    Forms\Components\TextInput::make('gmg_people')->integer(),
                    Forms\Components\FileUpload::make('gmg_file'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\ImageColumn::make('gmg_file'),
                Tables\Columns\TextColumn::make('gmg_name')->limit(15)->wrap(),
                Tables\Columns\TextColumn::make('gmg_percentage')->limit(20)->wrap(),
                Tables\Columns\TextColumn::make('gmg_increase_stock')->date(),
                Tables\Columns\TextColumn::make('gmg_people'),
                Tables\Columns\TextColumn::make('created_at'),
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
            'index' => Pages\ListInvestments::route('/'),
//            'create' => Pages\CreateInvestment::route('/create'),
//            'edit' => Pages\EditInvestment::route('/{record}/edit'),
        ];
    }
}
