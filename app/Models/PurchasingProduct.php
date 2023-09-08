<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchasingProduct extends Model
{
    use HasFactory;
    public $fillable = [
        'user_id',
        'nft_product_id',
        'nft_title',
        'nft_like',
        'nft_price',
        'nft_amount_pay',
        'nft_coin_type',
        'nft_image',
        'nft_buy_date',
        'nft_status_process',
    ];
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
