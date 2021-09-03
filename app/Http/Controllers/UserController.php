<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials, $request->filled('remember_me')))
        {
            return redirect()->route('home');
        }

        return back()->withErrors([
            'password' => 'Username atau password salah',
        ]);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'bail|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required',
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('login')->with('status', 'Berhasil membuat akun baru');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('home');
    }
}
