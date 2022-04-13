<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\OrdersStatuses;
use App\Models\OrdersMessages;
use App\Models\OrdersItems;
use App\Models\Delivery;

class Orders extends Model
{
    use HasFactory;
    protected $guarded = [];
    function customer() {
        return $this->belongsTo(Customers::class, 'customer_id');
    }

    function status() {
        return $this->belongsTo(OrdersStatuses::class, 'status_id');
    }

    function delivery() {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }

    function messages() {
        $this->hasMany(OrdersMessages::class, 'order_id');
    }

    function items() {
        return $this->hasMany(OrdersItems::class, 'order_id');
    }
}
