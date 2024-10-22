<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\AccountActivationMail;
use App\Mail\CustomerActivationMail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class registerController extends Controller
{
    public function index() {
        $customer = auth()->guard('customer')->user(); 
        return view('customer.index',compact('customer'));
      }
      public function showRegisterForm() {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.dashboard'); // Redirect to customer dashboard
        }
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('Super Admin')) {
                return redirect()->route('root'); // Redirect to admin/root dashboard
            }
        }
        return view('Auth.register');
    }
      public function processRegister(Request $request) {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
          'name' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:customers',
          'password' => 'required|string|confirmed',
       ]);
        if($validator->fails()) {
          return redirect()->back()->withErrors($validator)->withInput();
        }
        // Generate an activation token
     $activationToken = Str::random(60);
         $customer = Customer::create([
             'name' => $request->name,
             'email' => $request->email,
             'password' => Hash::make($request->password),
           'activation_token' => $activationToken,
         ]);
         Mail::to($customer->email)->send(new CustomerActivationMail($customer));
         return redirect()->route('customer.login')->with('message', 'A verification email has been sent to your email address. Please check your inbox.');
      }
    
      public function activateAccount($token) {
        $customer = Customer::where('activation_token', $token)->first();
        if (!$customer) {
            return redirect()->route('customer.login')->with('error', 'Invalid activation token.');
        }
        // Auth::login($customer);
        // Activate the user account
        $customer->update(['status' => true, 'activation_token' => null]);
        Auth::guard('customer')->login($customer);
        return redirect()->route('customer.dashboard')->with('message','login success guard works');
    }
    public function processLogin(Request $request) {
        dd($request->all());
    }
    public function login() {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.dashboard'); // Redirect to customer dashboard
        }
        return view('Auth.login');
    }
}
