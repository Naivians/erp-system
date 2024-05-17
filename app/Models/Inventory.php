<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $fillable = [
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
    ];
}
