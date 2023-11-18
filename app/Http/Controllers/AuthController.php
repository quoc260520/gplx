<?php

namespace App\Http\Controllers;

use App\Models\DrivingLicense;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
        ]);
        $user = User::where('email', $request->get('email'))->first();
        if (!$user || !Auth::attempt($request->only(['email', 'password']))) {
            return back()->withErrors('Mật khẩu không chính xác');
        }

        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->withErrors('Mật khẩu không chính xác');
    }

    public function dashboard(Request $request)
    {
        $gplxByUser = DrivingLicense::where('user_id', Auth::user()->id)->count();
        return view('admin.auth.profile')->with('gplxByUser', $gplxByUser);
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
