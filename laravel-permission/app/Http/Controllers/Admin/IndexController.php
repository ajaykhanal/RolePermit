<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function update_profile_data(Request $request,$id){
        $user = User::findOrFail($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->update();
        return back()->with('message', 'Profile updated.');
    }

    public function change_password(){
        return view('admin.users.change_password');
    }

    public function update_password(Request $request){
        //    dd('helo');


            if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
                // The passwords matches
                return back()->with("error","Your current password does not matches with the password.");
            }

            if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
                // Current password and new password same
                return back()->with("error","New Password cannot be same as your current password.");
            }

            $request->validate([
                'current_password' => ['required'],
                'new_password' => ['required'],
                'password_confirmation' => ['same:new_password'],
            ]);
            $user = Auth::user();
            $user->password = bcrypt($request->get('new_password'));
            $user->save();
            return back()->with("message","Password successfully changed!");
        }
}
