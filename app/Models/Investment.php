<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;
    protected $fillable = [
        'gmg_name',
        'gmg_percentage',
        'gmg_increase_stock',
        'gmg_people',
        'gmg_file',
    ];
}
