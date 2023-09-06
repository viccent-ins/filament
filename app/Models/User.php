<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'user_address',
        'phone',
        'password',
        'email',
        'name',
        'user_level',
        'score',
        'invite_code',
        'score',
        'login_time',
        'is_delete',
        'date_of_birth',
        'role',
        'eth_freeze_amount',
        'eth_auth_amount',
        'eth_available_quota',
        'usdt_cumulative',
        'usdt_freezing',
        'usdt_USDT',
        'eth_cumulative_income',
        'eth_today_income',
        'eth_convertible',
    ];

    use HasApiTokens, HasFactory, Notifiable, HasRoles ;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function canAccessFilament(): bool
    {
        return $this->hasRole('admin');
    }
    public function withdrawals(): BelongsTo {
        return $this->belongsTo(Withdraw::class,'user_id');
    }
    public function BankCardManagements(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function assets(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function nftProducts(): HasMany {
        return $this->hasMany(NftProduct::class, 'user_id');
    }
}
