<?php

namespace App\Http\Controllers;

use App\Models\mailSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
use Exception;
class mailSettingsController extends Controller
{
    public function index() {
        $settings = mailSetting::all()->pluck('value', 'key');
        return view('mail.index',compact('settings'));
    }
    public function update(Request $request)
    {
        // Validate the request inputs
        $validator = Validator::make($request->all(),[
            'mail_mailer' => 'required|string',
            'mail_host' => 'required|string',
            'mail_port' => 'required|integer',
            'mail_username' => 'required|string',
            'mail_password' => 'required|string',
            'mail_encryption' => 'nullable|string',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->route('mail.index')->withErrors($validator);
        }
        // Loop through each request data and save the settings
        foreach ($request->except('_token') as $key => $value) {
            mailSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        cache()->forget('config');
        config()->set([]);

        return redirect()->back()->with('success', 'Mail settings updated successfully.');
    }
    // public function sendTestEmail(Request $request)
    // {
    //     // dd(config('mail'));
    //     try {
    //         Mail::to('mitaliaher2002@gmail.com')
    //             ->send(new TestEmail());
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Email sent successfully.'
    //         ], 200);

    //     } catch (Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'An error occurred: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
}
