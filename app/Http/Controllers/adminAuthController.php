<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class adminAuthController extends Controller
{
   public function index() {
    if (Auth::check() && Auth::user()->hasRole('Super Admin')) {
        return redirect()->route('root'); 
    }
    return view('admin.login');
   }
   public function processLogin(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Gather credentials
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            if ($user->hasRole('Super Admin')) { // Check if user is admin
                return redirect()->route('root'); // Redirect to admin dashboard
            } else {
                Auth::logout(); // Log out the user if they are not an admin
                return back()->withErrors([
                    'email' => 'Access denied. Only admin roles can log in.',
                ])->withInput($request->only('email'));
            }
        }
        return back()->withErrors([
            'email' => 'Invalid credentials. Please try again.',
        ])->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
