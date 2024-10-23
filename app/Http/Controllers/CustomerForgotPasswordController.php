<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class CustomerForgotPasswordController extends Controller
{

    public function showLinkRequestForm() {
        return view('customer.forgot');
    }
    public function sendResetLinkEmail(Request $request)
{
    // dd($request->all());
    // Validate the request
    $validator = Validator::make($request->all(), [
        'email' => 'required|email'
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    $customerExists = \App\Models\Customer::where('email', $request->email)->exists();
    if ($customerExists) {
        $status = Password::broker('customers')->sendResetLink(
            $request->only('email')
        );
    } else {
        return redirect()->back()->withErrors(['email' => __('We can\'t find a user with that email address.')]);
    }
    if ($status === Password::RESET_LINK_SENT) {
        return redirect()->back()->with('status', __($status));
    }
    return redirect()->back()->withErrors(['email' => __($status)]);
}
}
