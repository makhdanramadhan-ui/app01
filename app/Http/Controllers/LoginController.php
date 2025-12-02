<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(Request $request) {
        return view('auth.login');
    }

    public function store(Request $request){
        // Validate the form data
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|min:6',
        ]);
        
        // Attempt to authenticate the user
        if (auth()->attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
        
        // Authentication failed...
        return back()->withErrors([
            'email' => 'Email atau Password salah.',
        ])->withInput();
            
        
    }
}
