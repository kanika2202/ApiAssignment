<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'customer_name','customer_phone',
        'address_line','city','note',
        'subtotal','shipping','total',
        'status',
        'payment_method','payment_status','payment_ref','receipt_image',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

}
