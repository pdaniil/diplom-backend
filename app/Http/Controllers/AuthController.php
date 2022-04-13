<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'login' => 'required|string|unique:customers,login',
            'password' => 'required|string',
            'name' => 'required|string',
            'is_admin' => 'required|integer',
        ]);

        $customer = Customers::create([
            'name' => $fields['name'],
            'login' => $fields['login'],
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
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
        $customer = Customers::where('login', $fields['login'])->first();

        if (!$customer || !Hash::check($fields['password'], $customer->password))
        {
            $response = [
                'message' => 'Bad login'
            ];
            return respone($response, 401);
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
