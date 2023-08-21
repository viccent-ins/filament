<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockbusterHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'date_end',
        'image',
        'amount_people',
        'other',
    ];
}
