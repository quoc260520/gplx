<?php

namespace App\Http\Controllers;

use App\Mail\MyTestEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MailController extends Controller
{
    public function sendMail($email, $name, $url)
    {
        try {
            return Mail::to($email)->send(new MyTestEmail($name, $url));
        } catch (\Throwable $th) {
            Log::channel('daily')->error($th->getMessage());
            return back()->withSuccess('Đã có lỗi xảy ra!');
        }
    }
    public function forgotPassWord(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return back()->withErrors('Email này không tồn tại!');
            }
            $token = Str::random(20);
            User::where('email', $user->email)->update([
                'remember_token' => $token,
            ]);
            $full_name = $user->full_name;
            $email = $user->email;
            $url = env('BASE_URL') . '/reset-password/?token=' . $token;
            $this->sendMail($email, $full_name, $url);
            return redirect()
                ->route('login')
                ->withSuccess('Vui lòng kiểm tra Email của bạn để xác nhận!');
        } catch (\Throwable $th) {
            return back()->withErrors('Đã có lỗi xảy ra');
        }
    }
}
