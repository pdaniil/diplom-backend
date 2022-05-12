<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Storages;

class StoragesController extends Controller
{
    public function updateMargin(Request $request) {
        if ($request->user()->is_admin) {
            $fields = $request->validate([
                'margin' => 'required|integer',
                'storage_id' => 'required|integer',
            ]);

            $storage = Storages::find($fields["storage_id"]);
            $storage->margin = $fields["margin"];
            $storage->sage();

            return response(["message" => "on margin update", "data" => $storage], 201);
        }
        else
            return response(["message" => 'not admin'], 401);

    }
    public function getStorages( Request $request ) {
        $storages = Storages::all();
        if ($request->user()->is_admin)
            return response( ["data" => $storages], 201 );
        else
            return response(["message" => 'not admin'], 401);
    }
}
