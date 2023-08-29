<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRecharge extends Model
{
    protected $fillable =
        [
            'order_id',
            'user_id',
            'refusal_reason_remark',
            'order_remark',
            'order_status',
            'order_creation_time',
            'order_approval_time',
        ];
    use HasFactory;

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
