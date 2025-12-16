<?php

namespace App\Http\Controllers\web;

use App\Models\User as ModelUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // public function FormRegister(){
    //     return view('auth.register');
    // }

    // public function Register(Request $request){
    //     $request->validate([
    //         'name'=>'required|string|max:255',
    //         'email' =>'required|email|unique:users',
    //         'password'=>'required|min:8|confirmed'
    //     ]);

    //     ModelUser::create([
    //         'name'=>$request->name,
    //         'email'=>$request->email,
    //         'password'=>Hash::make($request->password),

    //     ]);

    //     return redirect()->route('login')->with('success', 'Registrasi Berhasil, Silahkan Melakukan Login');
    // }

    public function FormLogin(){
        return view('auth.login');
    }

    public function Login(Request $request){
        $credentials= $request->validate([
            'email'=>['required','email'],
            'password'=> ['required'],
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success','Login Anda Berhasil');
        }
        return back()->withErrors([
            'email'=> 'Email Atau Password Salah',
        ])->onlyInput('email')->with('error', 'Email Atau Password Salah');
    }

    public function Logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
