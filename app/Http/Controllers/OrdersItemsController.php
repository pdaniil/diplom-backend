<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdersItems;
use App\Models\Storages;
use Illuminate\Http\Response;

class OrdersItemsController extends Controller
{
    public function create(Request $request) {
        $fields = $request->validate([
            'order_id' => 'required|integer',
            'storage' => 'required|string',
            'article' => 'required|string',
            'brand' => 'required|string',
            'title' => 'required|string',
            'price' => 'required|integer',
            'count' => 'required|integer',
            'delivery' => 'required|string',
        ]);
        $storage = Storages::where('title', $fields["storage"])->get();

        $item = OrdersItems::create(
            [
                "order_id" => $fields["order_id"],
                "storage_id" => $storage[0]["id"],
                "article" => $fields["article"],
                "brand" => $fields["brand"],
                "title" => $fields["title"],
                "price" => $fields["price"],
                "count" => $fields["count"],
                "delivery_date" => date('Y-m-d H:i:s', 86400 * $fields["delivery"] + time())
            ]
        );

        return response(["message" => 'on item creating'] , 201);
    }

    public function getItems( $order_id ) {
        $items = OrdersItems::where('order_id', $order_id)->get();
        return response(["items" => $items], 201);
    }
}
