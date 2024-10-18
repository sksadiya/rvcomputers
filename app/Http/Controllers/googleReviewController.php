<?php

namespace App\Http\Controllers;

use App\Models\reviewSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class googleReviewController extends Controller
{
    public function index() {
        $settings = reviewSetting::all()->pluck('value', 'key');
        return view('review.index',compact('settings'));
    }
    public function saveSettings(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'google_api_key' => 'required|string',
            'google_account_id' => 'required|string',
            'google_location_id' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->route('review.index')->withErrors($validator);
        }
        // Loop through each request data and save the settings
        foreach ($request->except('_token') as $key => $value) {
            reviewSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        // cache()->forget('config');
        // config()->set([]);

        return redirect()->back()->with('success', 'google settings updated successfully.');
    }
}
