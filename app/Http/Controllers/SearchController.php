<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Search\StoragesFactory;
use App\Models\Storages;
use Illuminate\Http\Response;

class SearchController extends Controller
{

    public function getStoragesId()
    {
        return response( [ "data" => Storages::getIds() ] , 201);
    }

    public function searchByArticle(Request $request)
    {
        //$storage_options = Storages::getConnectionOptions( $request['id'] );
        $storages = Storages::find( $request->id );
        $class = $storages->title;
        $storage = StoragesFactory::make($class);
        $storage->authenticate();
        $storage->getProducts( $request->article );
        return response(json_encode($storage),201);
    }
}
