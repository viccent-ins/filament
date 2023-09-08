<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchasingProductResource\Pages;
use App\Models\NftProduct;
use App\Models\PurchasingProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PurchasingProductResource extends Resource
{
    protected static ?string $model = PurchasingProduct::class;
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Shop';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('users.username'),
                    Forms\Components\TextInput::make('nft_title'),
                    Forms\Components\TextInput::make('nft_price')->numeric(),
                    Forms\Components\TextInput::make('nft_amount_pay'),
                    Forms\Components\TextInput::make('nft_coin_type')->string(),
                    Forms\Components\FileUpload::make('nft_image'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                ImageColumn::make('avtar')->label('Image')
                    ->defaultImageUrl(function (PurchasingProduct $record): string {
                        $explode = explode('/', $record->nft_image);
                        if ($explode[0] == 'assets') {
                            return url($record->nft_image);
                        }
                        return url('storage/' . $record->nft_image);
                    }),
            TextColumn::make('users.username')->label('username'),
            TextColumn::make('nft_title'),
            TextColumn::make('nft_price')->color('primary'),
            TextColumn::make('nft_amount_pay')->color('success'),
            TextColumn::make('nft_coin_type')->badge()->color('warning'),
            TextColumn::make('created_at')->label('Purchase Date')
                ->date('Y-m-d H:i:s'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Approve')
                    ->hidden(function (PurchasingProduct $record) {
                        if ($record->nft_status_process == 'requested') return false;
                        return true;
                    })
                    ->action(function (PurchasingProduct $record) {
                        if ($record->nft_status_process == 'requested') {
                            $nftProd = NftProduct::where('id', $record->nft_product_id)->first();
                            $record->nft_status_process = 'success';
                            $record->user_id = $nftProd->user_id;
                            $record->update();
//                           todo: remove product from list product
                            $nftProd->is_transfer = 1;
                            $nftProd->update();
                            Notification::make()
                                ->title('Approve Successfully!')
                                ->success()
                                ->send();
                        }
                    })
                    ->requiresConfirmation()
                    ->color('success'),
                Tables\Actions\Action::make('Reject')
                    ->hidden(function (PurchasingProduct $record) {
                        if ($record->nft_status_process == 'requested') return false;
                        return true;
                    })
                    ->action(function (PurchasingProduct $record) {
                        if ($record->nft_status_process == 'requested') {
                            $record->nft_status_process = 'failed';
                            $record->update();
                            Notification::make()
                                ->title('Product Rejected!')
                                ->danger()
                                ->send();
                        }
                    })
                    ->requiresConfirmation()
                    ->color('danger'),
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

        ];
    }
    public static function canCreate(): bool
    {
//        if (auth()->user()->hasRole('Super Admin')) return true;
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchasingProducts::route('/'),
//            'create' => Pages\CreatePurchasingProduct::route('/create'),
//            'edit' => Pages\EditPurchasingProduct::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('nft_status_process', 'requested');
    }
}
