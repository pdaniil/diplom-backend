<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;
use App\Models\OrdersMessagesDocs;
class OrdersMessages extends Model
{
    use HasFactory;
    protected $guarded = [];
    function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
