<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'date',
        'total',
        'order_status_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function orderStatus(){
        return $this->belongsTo(OrderStatus::class);
    }
}
