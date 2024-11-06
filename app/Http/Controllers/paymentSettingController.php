<?php

namespace App\Http\Controllers;

use App\Models\paymentSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class paymentSettingController extends Controller
{
    public function index() {
        $settings = paymentSettings::all()->pluck('value', 'key');
        return view('payment.index',compact('settings'));
    }
    public function saveSettings(Request $request)
    {
        // dd($request->all());
        $request->merge([
            'razorpay_payment' => $request->has('razorpay_payment') ? 1 : 0,
            'cod_payment' => $request->has('cod_payment') ? 1 : 0
        ]);
        $validator = Validator::make($request->all(),[
            'razorpay_payment' => 'required|boolean',
            'razorpay_key_id' => 'required|string',
            'razorpay_secret_id' => 'required',
            'razorpay_customer_identifier' => 'required',
            'razorpay_webhook_id' => 'nullable|string',
            'cod_payment' => 'nullable|boolean',
            'shipping_charges' => 'nullable|numeric'
        ]);
        if ($validator->fails()) {
            return redirect()->route('payment.index')->withErrors($validator);
        }
        // Loop through each request data and save the settings
        foreach ($request->except('_token') as $key => $value) {
            paymentSettings::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        // cache()->forget('config');
        // config()->set([]);

        return redirect()->back()->with('success', 'Payment settings updated successfully.');
    }
}
