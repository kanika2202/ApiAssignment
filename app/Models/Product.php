<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'ProductName',
        'Price',
        'ProductImage',
        'CategoryID',
        'discount_percent', // New field for promotion
        'is_promo',        // New field to toggle promotion
    ];
    function category()
    {
        return $this->belongsTo(Category::class, 'CategoryID');
    }
}
