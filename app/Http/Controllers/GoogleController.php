<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback(){
        $user = Socialite::driver('google')->stateless()->user();

        $findUser= User::where('google_id', $user->id)->first();

        if($findUser){
            Auth::login($findUser);
            return redirect()->route('user.products.index')->with(['success'=>'You are logged in with Google']);
        }
        else{
            $newUser = User::create([
                'email' => $user->email,
                'name' => $user->name,
                'google_id'=> $user->id,
                'password' => encrypt('abcd1234')
            ]);
            Auth::login($newUser);
        }
        return redirect()->route('user.products.index')->with(['success'=>'Your account has been created successfully with Google']);
    }
}
