<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NftProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'art_id',
        'user_id',
        'nft_title',
        'nft_like',
        'nft_click',
        'nft_price',
        'nft_coin_type',
        'nft_image',

    ];
    public function artCategories(): BelongsTo {
        return $this->belongsTo(ArtCategory::class, 'art_id');
    }
    public function users(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
