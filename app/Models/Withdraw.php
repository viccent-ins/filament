<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdraw extends Model
{
    use HasFactory;
    protected $fillable = [
        'withdraw_amount',
        'withdraw_bank',
        'user_id',
    ];
    public function users(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
