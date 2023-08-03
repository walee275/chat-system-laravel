<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function view(){
        return view('auth.login');
    }



    public function login(Request $request){
        $this->validate($request, [
            'email' =>'required|email',
            'password' =>'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();
        $credantials = $request->except('_token', 'remember');

        if(Auth::attempt($credantials)){
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }




    public function create(){
        return view('auth.register');
    }




    public function register(Request $request){
        $this->validate($request, [
            'name' =>'required',
            'email' =>'required|email',
            'password' =>'required|min:3',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if($user){
            Auth::login($user);
            return redirect()->route('home');
        }else{
            return redirect()->back()->with('error', 'Failed to register');
        }

    }










    public function logout()
{
    Auth::logout();
    return redirect()->route('login');
}
}
