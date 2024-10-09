<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class adminController extends Controller
{
  public function index()
  {
    return view('admin.dashboard');
  }
  public function profile()
  {
    return view('admin.profile');
  }
  public function updateProfile(Request $request, $id)
  {
    // dd($request->all());
    $user = User::find($id);
    if (!$user) {
      return redirect()->route('welcome')->with('error', 'User Not Found');
    }

    $validator = Validator::make($request->all(), [
      'name' => 'required|min:6',
      'email' => 'required|email|unique:users,email,' . $id,
      'contact' => 'required|digits:10',
      'avatar' => 'nullable|string',
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    // Update basic user information
    $user->name = $request->name;
    $user->email = $request->email;
    $user->contact = $request->contact;
    $user->avatar = $request->avatar;

    // Handle avatar upload
    // if ($request->hasFile('avatar')) {
    //   $defaultAvatar = 'user-dummy-img.jpg';

    //   // Check if there is an existing avatar that is not the default one
    //   if ($user->avatar && $user->avatar !== $defaultAvatar && file_exists(base_path('assets/images/users/' . $user->avatar))) {
    //     unlink(base_path('assets/images/users/' . $user->avatar));
    //   }

    //   $avatar = $request->file('avatar');
    //   $avatarName = time() . 'user.' . $avatar->getClientOriginalExtension();
    //   $avatar->move(base_path('assets/images/users'), $avatarName);

    //   $user->avatar = $avatarName;
    // }

    $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully');
  }

  public function updatePassword(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'current_password' => ['required', 'string'],
      'password' => ['required', 'string', 'confirmed'],
    ]);
    if ($validator->fails()) {
      return redirect()->route('admin.profile')->withErrors($validator)->withInput();
    }
    if (!Hash::check($request->current_password, Auth::user()->password)) {
      return redirect()->back()->withErrors(['current_password' => 'Your current password does not match.'])->withInput();
    }
    $user = Auth::user();
    $user->password = Hash::make($request->password);
    $user->save();

    // Flash success message
    Session::flash('success', 'Password updated successfully!');

    return redirect()->back();
  }
}
