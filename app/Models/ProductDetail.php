<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    protected $fillable=[
        'product_id',
        'image',
        'color_id',
        'original_cost',
        'discount',
        'amount',
        'user_change'
    ];
}
