<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;

class CustomerController extends Controller
{

    public function allCustomers() {

        return Customers::all();
    }

    public function byId($id) {

        return Customers::find($id)->orders()->get();
    }
}
