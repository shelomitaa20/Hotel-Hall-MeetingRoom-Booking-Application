<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                return redirect()->intended('/admin');
            } elseif ($user->role == 'resepsionis') {
                return redirect()->intended('resepsionis/checkin');
            } else {
                return redirect()->intended('riwayat_booking');
            }
        }

        return redirect('login')->withErrors('Login details are not valid');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pengunjung', // Automatically set the role to 'pengunjung'
        ]);

        return redirect('login')->with('success', 'Registration successful. Please login.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
