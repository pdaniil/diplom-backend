<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Storages;
class StoragesTypes extends Model
{
    use HasFactory;
    protected $guarded = [];
    function storages() {
        return $this->hasMany(Storages::class, 'type_id');
    }
}
