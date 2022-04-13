<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;
use Laravel\Sanctum\HasApiTokens;

class Customers extends Model
{
    use HasApiTokens, HasFactory;
    protected $guarded = [];
    function orders() {
        return $this->hasMany(Orders::class, 'customer_id');
    }
}
