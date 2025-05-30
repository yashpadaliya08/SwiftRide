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

        // Add role to ensure only client users login here
        if (Auth::guard('web')->attempt(array_merge($credentials, ['role' => 'client']))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client',
        ]);

        Auth::guard('web')->login($user);

        return redirect()->route('dashboard');
    }

    // Logout client
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.auth');

    }
}
