<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class CustomerResetPasswordController extends Controller
{
    public function showResetForm($token) {
        return view('customer.reset', ['token' => $token]);
    }
    public function reset(Request $request)
{
    // dd($request->all());
    // Validate the request
    $validator = Validator::make($request->all(), [
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    $status = null;
    $customerExists = \App\Models\Customer::where('email', $request->email)->exists();
    if ($customerExists) {
        $status = Password::broker('customers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($customer, $password) {
                $customer->password = Hash::make($password);
                $customer->save();
            }
        );
    }
    if ($status === Password::PASSWORD_RESET) {
        return redirect()->route('customer.login')->with('status', __($status));
    }
    return redirect()->back()->withErrors(['email' => [__($status ?? 'Password reset failed.')]]);
}
    
}
