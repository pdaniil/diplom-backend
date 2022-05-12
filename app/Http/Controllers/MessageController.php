<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Orders;
use App\Models\Customers;
use App\Models\OrdersMessages;

class MessageController extends Controller
{
    public function createMessage( Request $request ) {

        $fields = $request->validate([
            "order_id" => "required|integer",
            "text" => "required|string",
            "is_customer" => "required|boolean",
            "user_name" => "required|string"
        ]);

        $message = OrdersMessages::create([
            "order_id" => $fields["order_id"],
            "text" => $fields["text"],
            "is_customer" => $fields["is_customer"],
            "user_name" => $fields["user_name"],
            "view" => false
        ]);

        return response(["message" => "on message creating", "data" => $message], 201);

    }

    public function getChat( $order_id ) {
        $chat = OrdersMessages::where('order_id' , $order_id)->get();
        return response(["message" => "on chat getting", "chat" => $chat], 201);
    }

    public function setMessagesView( Request $request ) {
        $fields = $request->validate([
            "order_id" => "required|integer",
            "is_customer" => "required|boolean",
        ]);
        $chat = OrdersMessages::where('order_id' , $fields["order_id"])->where('is_customer', !$fields["is_customer"])->get();
        foreach($chat as  $message ) {
            $dbMessage = OrdersMessages::find( $message["id"] );
            $dbMessage["view"] = true;
            $dbMessage->save();
        }
    }

    public function getChatListByUserId( $user_id ) {
        $orders = Orders::where('customer_id', $user_id)->get();
        $chatList = [];
        foreach ($orders as $order) {
            $lastMessage = OrdersMessages::where('order_id', $order["id"])->orderByDesc('created_at')->first();
            if (!$lastMessage["is_customer"] )
                $view = $lastMessage["view"];
            else
                $view = true;

            $chatInfo = [
                "userName" => $lastMessage["user_name"],
                "lastMessage" => $lastMessage["text"],
                "orderId" => $order["id"],
                "timeLastMessage" => $lastMessage["created_at"],
                "messageViewed" => $view
            ];

            array_push($chatList, $chatInfo);
        }

        return response(["data" => array_reverse($chatList)], 201);
    }

    public function getChatListForAdmin( Request $request ) {
        if ($request->user()->is_admin)
        {
            $orders = Orders::all();
            $chatList = [];
            foreach ($orders as $order) {
                $lastMessage = OrdersMessages::where('order_id', $order["id"])->orderByDesc('created_at')->first();
                if ($lastMessage["is_customer"] )
                    $view = $lastMessage["view"];
                else
                    $view = true;

                $chatInfo = [
                    "userName" => $lastMessage["user_name"],
                    "lastMessage" => $lastMessage["text"],
                    "orderId" => $order["id"],
                    "timeLastMessage" => $lastMessage["created_at"],
                    "messageViewed" => $view
                ];

                array_push($chatList, $chatInfo);
            }

            return response(["data" => array_reverse($chatList)], 201);

        }
        else
        {
            return response(["message" => 'not admin'], 401);
        }
    }

}
