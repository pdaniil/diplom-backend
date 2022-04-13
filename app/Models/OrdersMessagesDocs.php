<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrdersMessages;
class OrdersMessagesDocs extends Model
{
    use HasFactory;
    protected $guarded = [];
    function message() {
        return $this->belongsTo(OrdersMessages::class, 'message_id');
    }
    
}
