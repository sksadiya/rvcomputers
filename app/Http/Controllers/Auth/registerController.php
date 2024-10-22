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
    public function index()
    {
        $customer = auth()->guard('customer')->user();
        return view('customer.index', compact('customer'));
    }
    public function showRegisterForm()
    {
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
    public function processRegister(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|confirmed',
        ]);
        if ($validator->fails()) {
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

    public function activateAccount($token)
{
    // Find the customer by activation token
    $customer = Customer::where('activation_token', $token)->first();

    // If no customer found, redirect with an error
    if (!$customer) {
        return redirect()->route('customer.login')->with('error', 'Invalid activation token.');
    }

    // Activate the user account
    $customer->update(['status' => true, 'activation_token' => null]);

    // Log in the customer
    Auth::guard('customer')->login($customer);

    // Redirect to the dashboard with a success message
    return redirect()->route('customer.dashboard')->with('message', 'Login successful, your account is now activated.');
}

    public function processLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        // Logout the admin if logged in
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            $user = Auth::guard('customer')->user();
            if ($user->status) {
                return redirect()->route('customer.dashboard');
            } else {
                Auth::guard('customer')->logout();
                return redirect()->back()->withErrors(['email' => 'Your account is inactive. Please contact support.']);
            }
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials.']);
    }
    public function login()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.dashboard'); // Redirect to customer dashboard
        }
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('Super Admin')) {
                return redirect()->route('root'); // Redirect to admin/root dashboard
            }
        }
        return view('Auth.login');
    }
}
