<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class authcontroller extends Controller
{
    
    public function login() {
        return view("auth.login");
    }

    public function loginHandle(Request $request) {
        $credentials = $request->validate([
            "email"=> "required",
            "password"=> "required",
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect()->route('admin.index')->with('success', 'Berhasil Login');
            } else if ($user->role == 'petugas') {
                return redirect()->route('petugas.index')->with('success', 'Berhasil Login');
            }
        } else {
            return back()->with('error', 'Email atau Password salah');
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil Log Out');
    }

    public function error(){
        return view('auth.error');
    }

}
