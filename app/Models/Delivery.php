<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;
class Delivery extends Model
{
    use HasFactory;
    function orders() {
        return $this->hasMany(Orders::class, 'delivery_id');
    }
}
