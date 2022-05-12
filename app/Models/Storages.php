<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;
use App\Models\StorageOptions;
class Storages extends Model
{
    use HasFactory;
    protected $guarded = [];

    function getIds()
    {
        $result = [];
        foreach (self::all() as $storage)
            array_push($result, $storage->id);
        return $result;
    }
    function getConnectionOptions( $id ) {
        return self::find($id)->json_connection_params;
    }

    function orders() {
        return $this->hasMany(Orders::class, 'storage_id');
    }

    function options() {
        return $this->hasMany(StorageOptions::class, 'storage_id');
    }
}
