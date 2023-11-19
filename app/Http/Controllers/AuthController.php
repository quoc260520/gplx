<?php

namespace App\Http\Controllers;

use App\Models\DrivingLicense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'full_name' => 'required',
        ]);
        $user = User::where('email', $request->get('email'))->first();
        if($user) {
            return back()->withErrors('Tài khoản đã tồn tại!');
        }
        $userCreate = User::create([
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);
        return redirect(route('login'))->withSuccess('Đăng kí tài khoản thành công');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function getViewReset(Request $request) {
        return view('reset-password', ['token'=> $request->token]);
    }

    public function resetPassword(Request $request) {
        try {
            $request->validate([
                'password' => 'required|confirmed|min:6',
                'password_confirm' => 'required|min:6',
                'token' => 'required'
            ]);
            $user = User::where('remember_token', $request->token);
            if(!$user) {
                return back()->withErrors('Không tìm thấy người dùng');
            }
            User::where('email', $user->email)->update([
                'password' => Hash::make($request->password)
            ]);
            return redirect()->route('login')->withSuccess('Đặt Lại Mật Khẩu Thành Công');
        } catch (\Throwable $th) {
            return back()->withErros('Đã Có Lỗi Xảy Ra');
        }
    }
}
