<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;
use App\Models\Storages;

class OrdersItems extends Model
{
    use HasFactory;
    protected $guarded = [];
    function order() {
        return $this->belongsTo(Orders::class, 'order_id');
    }
    function storage() {
        return $this->belongsTo(Storages::class, 'storage_id');
    }
}
