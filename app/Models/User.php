<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
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
        'mobile',
        'nick_name',
        'password',
        'email',
        'name',
        'date_of_birth',
        'referral',
        'role',
        'withdraw_password',
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
    public function deposits(): BelongsTo {
        return $this->belongsTo(Deposit::class, 'user_id');
    }
    public function withdrawals(): HasMany {
        return $this->hasMany(Deposit::class,'user_id');
    }
    public function BankCardManagements(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function assets(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
