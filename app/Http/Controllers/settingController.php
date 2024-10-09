<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class settingController extends Controller
{
    public function index() {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('settings.index',compact('settings'));
    }

    public function saveSettings(Request $request) {
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'company_name' => 'required|string',
            'organization_name' => 'required|string',
            'organization_address' => 'required|string',
            'mobile_number' => 'required|digits_between:1,13', 
            'phone_number' => 'required|digits_between:1,13',  
            'company_email' => 'required|email',
            'website' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            // 'company_logo' => 'nullable|file',
            // 'app_fevicon' => 'nullable|file',
            'google_map' => 'nullable'
        ]);
        if ($validator->fails()) {
            return redirect()->route('company.index')->withErrors($validator);
        }
        $files = $request->allFiles();
        // Loop through each request data and save the settings
        foreach ($request->except('_token') as $key => $value) {

            if ($request->hasFile($key)) {
                $file = $files[$key];
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $setting = Setting::where('key', $key)->first();

                // Delete the old file if it exists
                if ($setting && $setting->value) {
                    $oldFilePath = base_path('assets/images/users/' . $setting->value);
                    if (File::exists($oldFilePath)) {
                        File::delete($oldFilePath);
                    }
                }

                $file->move(base_path('assets/images/users/'), $filename);
                $value = $filename;
            }
        
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return redirect()->back()->with('success', 'Company settings updated successfully.');

    }
}
