<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestCorridor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'price', 'percentage', 'turn', 'image',
    ];
}
