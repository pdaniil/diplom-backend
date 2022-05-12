<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\OrdersItemsController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\StoragesController;
use App\Http\Controllers\StoragesTypesController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Без авторизации
Route::get('/profiles', [CustomerController::class, 'allCustomers']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/get-storages-id', [SearchController::class, 'getStoragesId']);
Route::post('/search', [SearchController::class, 'searchByArticle']);

//Требуют авторизации
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/profile', function (Request $request) {
        $customer = [
            "id" => $request->user()->id,
            "email" => $request->user()->login,
            "name" => $request->user()->name,
            "is_admin" => $request->user()->is_admin
        ];
        return $customer;
    });
    Route::get("/logout", [AuthController::class, 'logout']);


    Route::post("/order/create", [OrdersController::class, 'create']);
    Route::post("/order/items/create", [OrdersItemsController::class, 'create']);

    Route::get("/orders", [OrdersController::class, 'getOrders']);
    Route::get("/orders_items/{order_id}", [OrdersItemsController::class, 'getItems']);


    Route::post("/new_message", [MessageController::class, 'createMessage']);
    Route::get("/chat/{order_id}", [MessageController::class, 'getChat']);
    Route::get("/chat_list/{user_id}", [MessageController::class, 'getChatListByUserId']);

    Route::get("/admin/storages", [StoragesController::class, 'getStorages']);
    Route::post("/admin/create_storage", [StoragesController::class, 'createStorage']);
    Route::get("/admin/storages_types", [StoragesTypesController::class, 'getStoragesTypes']);
    Route::get("/admin/chat_list", [MessageController::class, 'getChatListForAdmin']);

    Route::post("/set_view_messages", [MessageController::class, 'setMessagesView']);
});