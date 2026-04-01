<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramLog extends Model
{
    use HasFactory;
    // ១. កំណត់ឈ្មោះតារាងឱ្យត្រូវនឹង Migration របស់អ្នក
    protected $table = 'telegram_logs';

    // ២. អនុញ្ញាតឱ្យបញ្ចូលទិន្នន័យ (Mass Assignment)
    protected $fillable = [
        'order_id',
        'message',
        'status',
    ];

    // ៣. បង្កើត Relationship ទៅកាន់ Order (ទុកសម្រាប់ធ្វើ Report)
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}