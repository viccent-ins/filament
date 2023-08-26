<?php

namespace App\Models\Assets;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Balance extends Model
{
    use HasFactory;
    protected $fillable = [
        'latest_balance',
        'previous_balance',
        'user_id',
    ];
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
