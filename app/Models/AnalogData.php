<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalogData extends Model
{
    use HasFactory;
    protected $fillable = [
        'member_id', 'profit_amount', 'image', 'date',
    ];
}