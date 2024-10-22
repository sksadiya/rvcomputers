<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class accountController extends Controller
{
    public function orders() {
        $customer = auth()->guard('customer')->user();
        return view('account.orders' ,compact('customer'));
    }
    public function address() {
        $countries = Country::where('status',1)->get();
        $customer = auth()->guard('customer')->user();
        return view('account.address',compact('countries','customer'));
    }
    public function settings() {
        $customer = auth()->guard('customer')->user();
        $countries = Country::where('status',1)->get();
        return view('account.settings',compact('customer','countries'));
    }
    public function updateAddress(Request $request) {
       // dd($request->all());
        $validator = Validator::make($request->all(), [
            'customer' => 'required|exists:customers,id',
            "billing_address" => "nullable|string",
            "billing_phone" => 'nullable|numeric',
            "billing_country" => "nullable|exists:country_info,id",
            "billing_state" => "nullable|exists:state_info,id",
            "billing_city" => "nullable|exists:city_info,id",
            "billing_postal" => "nullable|string",
            "shipping_address" => "nullable|string",
            "shipping_phone" => 'nullable|numeric',
            "shipping_country" => "nullable|exists:country_info,id",
            "shipping_state" =>"nullable|exists:state_info,id",
            "shipping_city" => "nullable|exists:city_info,id",
            "shipping_postal" => "nullable|string",
        ]);
        $customer = Customer::find($request->customer);
        $customer->billingAddress()->updateOrCreate(
            ['customer_id' => $customer->id],
            [
                'address_line_1' => $request->billing_address,
                'country_id' => $request->billing_country,
                'state_id' => $request->billing_state,
                'city_id' => $request->billing_city,
                'postal_code' => $request->billing_postal,
                'contact' => $request->billing_phone,
            ]
        );
        $customer->shippingAddress()->updateOrCreate(
            ['customer_id' => $customer->id],
            [
                'address_line_1' => $request->shipping_address,
                'country_id' => $request->shipping_country,
                'state_id' => $request->shipping_state,
                'city_id' => $request->shipping_city,
                'postal_code' => $request->shipping_postal,
                'contact' => $request->shipping_phone,
            ]
        );
        $success = true ;
        if($success) {
            return redirect()->back()->with('success' ,'Adresses updated successfully');
        }
        }
        
        public function updateProfile(Request $request) {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:customers,email,' . $request->customer,
                'contact' => 'nullable|numeric',
                'password' => 'nullable|string|confirmed',
                'avatar' => 'nullable|file|max:2048',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $customer = Customer::find($request->customer);
            if (!$customer) {
                return redirect()->back()->with('error', 'Customer not found.');
            }
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->contact = $request->contact;
            if ($request->filled('password')) {
                $customer->password  = Hash::make($request->password);
            }
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $avatarName = time() .'user'. '.' . $avatar->getClientOriginalExtension();
                $avatar->move(base_path('assets/images/users'), $avatarName);
                $customer->avatar = url('assets/images/users/' . $avatarName);
            }
            $customer->save();
            return redirect()->back()->with('success' ,'profile updated successfully');
        }
}
