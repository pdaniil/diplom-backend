<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        if (is_null($request["is_admin"]))
            $request["is_admin"] = 0;
        
        $fields = $request->validate([
            'email' => 'bail|required|string|email|unique:customers,login',
            'password' => 'bail|required|string',
            'name' => 'bail|required|string',
            'is_admin' => 'required|integer',
        ]);
        if ($request['password'] != $request["password_confirmed"])
            return response(["errors" => [0 => ["Пароли не совпадают."]]], 401);
        $customer = Customers::create([
            'name' => $fields['name'],
            'login' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'is_admin' => $fields['is_admin']
        ]);

        $token = $customer->createToken('shop')->plainTextToken;

        $response = [
            'customer' => $customer,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'bail|required|string',
            'password' => 'required|string',
        ]);
        $customer = Customers::where('login', $fields['email'])->first();

        if (!$customer || !Hash::check($fields['password'], $customer->password))
        {
            $response = [
                "message" => "The given data was invalid.",
                'errors' => [
                    "login" => [
                        0 => "Email или пароль введены неверно."
                    ]
                ]
            ];
            return response($response, 401);
        }
        
        $token = $customer->createToken('shop')->plainTextToken;

        $response = [
            'customer' => $customer,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        $response = [
            'message' => 'Logged out'
        ];

        return response($response, 201);
    }
}
