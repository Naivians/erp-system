<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stockout extends Model
{
    use HasFactory;
    
     protected $fillable = [
        'code',
        'category',
        'name',
        'description',
        'price',
        'stocks',
        'total_amount',
    ];
}
