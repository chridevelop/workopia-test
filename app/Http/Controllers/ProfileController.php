<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthServiceProvider;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    //@desc Update profile info
    //@route PUT /profile
    public function update(Request $request): RedirectResponse{
        $user = Auth::user();

        $validatData = $request->validate([
            'name'=> 'required|string',
            'email'=> 'required|string|email',
            'avatar'=> 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //Get Username and email
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        //Avatar Upload
        if($request->hasFile('avatar')){
            if($user->avatar){
                Storage::delete('public/'.$user->avatar);
            }

            //Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }
        $user->save();

        //Upadte user info
      //  $user->update($validatData);
        return redirect()->route('dashboard')->with('success','Profile updates successfully');
    }

}
