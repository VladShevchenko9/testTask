<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $email = (string)$request->input('email', '');
        $password = (string)$request->input('password', '');

        $user = User::query()->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with([
                'error' => 'User not found',
            ]);
        }

        if (!Hash::check($password, $user->password)) {
            return redirect()->back()->with([
                'error' => 'Invalid password',
            ]);
        }

        Auth::login($user);

        return redirect()->route('admin.home');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('auth.login');
    }
}
