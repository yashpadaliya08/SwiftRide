<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ClientAuthController extends Controller
{
    // Show combined login/register form for clients
    public function showAuthForm()
    {
        return view('client.auth.client_auth'); // Blade file for tabbed login/register
    }

    // Handle client login
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        // Try to authenticate with client role
        // Check if user exists and has client/user role
        $user = User::where('email', $credentials['email'])->first();
        
        if ($user && ($user->role === 'client' || $user->role === 'user')) {
            if (Auth::guard('web')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('dashboard');
            }
        }


        return back()->withErrors([
            'login' => 'Invalid credentials or not a client account.',
        ])->withInput($request->only('email'));
    }

    // Handle client registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        // Use 'user' role to match database enum, but treat as client
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Database enum uses 'user' not 'client'
        ]);

        Auth::guard('web')->login($user);

        return redirect()->route('dashboard');
    }

    // Logout client
    public function logout(Request $request)
    {
        // Only logout from web guard, don't invalidate entire session
        // This allows admin to remain logged in if they're also logged in
        Auth::guard('web')->logout();
        
        // Regenerate CSRF token for security (doesn't affect other guards)
        $request->session()->regenerateToken();

        return redirect()->route('client.auth');
    }
}
