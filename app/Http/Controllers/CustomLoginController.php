<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CustomLoginController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'user_name' => 'required',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');
        if (Auth::attempt(['user_name' => $credentials['user_name'], 'password' => $credentials['password']], $remember)) {
            $user = Auth::user();

            if ($user->first_login_at === null) {
                // This is the user's first login.
                $user->update([
                    'first_login_at' => now(),
                ]);

//                Storage::disk('local')->put('defaultDateType', 'jalali');
//
//                // Set a cookie to remember the date type choice for 7 days
//                Cookie::queue('localStorageDateType', 'jalali', 7);
            }
            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'user_name' => ['The provided credentials do not match our records.'],
        ]);
    }
}
