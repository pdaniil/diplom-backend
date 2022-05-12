<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrdersItems;
use App\Models\OrdersStatuses;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrdersController extends Controller
{
    public function create(Request $request) {
        $fields = $request->validate([
            'customer_id' => 'required|integer',
            'payment' => 'required|string',
            'delivery' => 'required|string',
        ]);
        $status = OrdersStatuses::where('title', 'Создан')->get();
        $order = Orders::create([
            'receive_time' => date('Y-m-d H:i:s',time()),
            'delivery' => $fields['delivery'],
            'payment' => $fields['payment'],
            'customer_id' => $fields['customer_id'],
            'status_id' => $status[0]["id"]
        ]);
        
        return response(["message" => 'on order creating', "order" => $order], 201);
    }

    public function getOrders( Request $request ) {
        $orders = Orders::where('customer_id', $request->user()->id)->orderBy('receive_time', 'desc')->get();
        foreach ( $orders as $key => $order )
        {
            $items = OrdersItems::where('order_id', $order->id)->get();
            $total_sum = 0;
            foreach ($items as $item) {
                $total_sum += $item->price * $item->count;
            }
            $status = OrdersStatuses::where('id', $order->status_id)->get();
            $orders[$key]->sum = $total_sum;
            $orders[$key]->status = $status[0]->title;
        }
        return response(['orders' => $orders], 201);
    }
}
