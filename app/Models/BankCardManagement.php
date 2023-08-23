<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BankCardManagement extends Model
{
    use HasFactory;
    protected $fillable = [
        'card_name',
        'card_address',
        'card_address_2',
        'others',
        'user_id',
    ];
    public function users(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
