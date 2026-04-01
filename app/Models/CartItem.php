<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    // អនុញ្ញាតឱ្យបញ្ចូលទិន្នន័យក្នុង column ទាំងនេះ
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    // បង្កើត Relationship ទៅកាន់ Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}