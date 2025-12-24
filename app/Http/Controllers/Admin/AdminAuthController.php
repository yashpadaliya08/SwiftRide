<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    // Show admin login/register tabbed form
    public function showAuthForm()
    {
        return view('admin.auth.admin_auth');
    }

    // Admin login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt(array_merge($credentials, ['role' => 'admin']))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'login' => 'Invalid credentials or not an admin account.',
        ])->withInput($request->only('email'));
    }

    // Admin register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

       Auth::guard('admin')->login($user);

        return redirect()->route('admin.dashboard');
    }

    // Admin logout
    public function logout(Request $request)
    {
        // Only logout from admin guard, don't invalidate entire session
        // This allows client to remain logged in if they're also logged in
        Auth::guard('admin')->logout();
        
        // Regenerate CSRF token for security (doesn't affect other guards)
        $request->session()->regenerateToken();

        return redirect()->route('admin.auth');
    }
}
