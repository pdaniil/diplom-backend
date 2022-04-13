<?php
namespace App\Models\Search;
use App\Models\Storages\ATrust;
use App\Models\Storages\AutoEuro;
class StoragesFactory implements IStoragesFactory
{
    protected static $availableStorages = [
        'ATrust' => ATrust::class,
        'AutoEuro' => AutoEuro::class
    ];
    public function make($storage, $params = null)  {
        $class = self::$availableStorages[$storage];
        return new $class( $params );
    }
}

