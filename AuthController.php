<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginCheck(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        // Plain password check (NO HASH)
        if ($user && $user->password === $request->password) {
            session(['user_id' => $user->id]);
            return redirect()->route('admin.page');
        }

        return back()->with('error', 'Invalid Email or Password');
    }

    public function adminPage()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        return view('admin.dashboard', [
            'users'     => User::count(),
            'tasks'     => Task::count(),
            'completed' => Task::where('status', 'completed')->count(),
            'pending'   => Task::where('status', 'pending')->count(),
        ]);
    }

    public function logout()
    {
        session()->forget('user_id');
        return redirect()->route('login');
    }
}
