<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class accountController extends Controller
{
    public function orders() {
        return view('account.orders');
    }
    public function address() {
        $countries = Country::all();
        return view('account.address',compact('countries'));
    }
    public function settings() {
        return view('account.settings');
    }
}
