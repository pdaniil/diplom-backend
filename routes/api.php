<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
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
});