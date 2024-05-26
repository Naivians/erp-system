<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'category',
        'name',
        'description',
        'price',
        'beg_inv',
        'initial',
        'stockin',
        'stockout',
        'end_inv',
        'total_amount',
        'remarks',
    ];
}
