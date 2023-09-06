<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArtCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'art_level',
        'art_price_start',
        'art_price_end',
        'art_coin_type',
        'art_image',
        'art_other',
    ];
    public function nftProducts (): HasMany {
        return $this->hasMany(NftProduct::class);
    }
}
