<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the login form
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Username atau ID Card harus diisi.',
            'login.string' => 'Format login tidak valid.',

            'password.required' => 'Kata sandi harus diisi.',
            'password.string' => 'Format kata sandi tidak valid.',
        ]);


        // Check if login is ID Card, User ID, or Username
        $loginField = filter_var($request->login, FILTER_VALIDATE_INT) ? 'id_card' : 'username';

        // If it's not a user_id (integer), check if it's an id_card or username
        if ($loginField === 'username') {
            $user = User::where('username', $request->login)
                ->orWhere('id_card', $request->login)
                ->first();
        } else {
            $user = User::where('id_card', $request->login)->first();
        }

        // Check if user exists and password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['Kredensial yang diberikan tidak cocok dengan data kami.'],
            ]);
        }

        // Login the user
        Auth::login($user, $request->boolean('remember'));

        // Redirect based on user role
        if ($user->role === 'admin') {
            return redirect()->intended(route('dashboard'));
        } else {
            return redirect()->intended(route('user.dashboard'));
        }
    }

    /**
     * Handle logout request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
