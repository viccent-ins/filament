<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Balance extends Model
{
    use HasFactory;
    protected $fillable = [
        'usdt_amount',
        'usdt_prev_balance',
        'user_id',
        'approve_by',
        'type',
    ];
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
