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
        'login_time',
        'is_delete',
        'date_of_birth',
        'role',
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
