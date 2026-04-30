<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Get user by email
        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        // 2. Check password using HASH
        if ($user && Hash::check($request->password, $user->password)) {

            session(['user' => $user]);

            return redirect('/')->with('success', 'Login success 🔥');
        }

        return back()->with('error', 'Invalid email or password ❌');
    }

public function logout()
{
    session()->flush(); // clear all session

    return redirect('/')->with('success', 'Logged out 👋');
}
}