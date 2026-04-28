<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendAccountDetailsMail;
use App\Models\User;
use App\Services\XSenderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Route based on user role
            if (Auth::user()->isAdmin()) {
                return redirect()->intended('admin/dashboard');
            }

            return redirect()->intended(route('user.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau Password salah.',
        ])->onlyInput('email');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['whatsapp' => 'required|string|max:20']);

        $phone = preg_replace('/[^0-9]/', '', $request->whatsapp);
        $user = User::where('whatsapp', 'LIKE', '%' . substr($phone, -8) . '%')->first();

        if (!$user) {
            return response()->json(['ok' => false, 'message' => 'Nomor WhatsApp tidak terdaftar. Silahkan order di mawkost untuk mendapatkan akun.']);
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        cache()->put('otp_' . $phone, ['code' => $otp, 'user_id' => $user->id], 300);

        $xsender = new XSenderService();
        if (!$xsender->isEnabled()) {
            return response()->json(['ok' => false, 'message' => 'WhatsApp API belum aktif. Hubungi admin.']);
        }

        $msg = "🔐 *Kode OTP mawkost*\n\n"
            . "Kode verifikasi login kamu:\n\n"
            . "▶️ *{$otp}*\n\n"
            . "Kode berlaku 5 menit.\n"
            . "_Jangan bagikan kode ini ke siapapun._";

        $res = $xsender->send($request->whatsapp, $msg);

        if ($res['ok']) {
            return response()->json(['ok' => true, 'message' => 'Kode OTP telah dikirim ke WhatsApp kamu.']);
        }

        return response()->json(['ok' => false, 'message' => 'Gagal mengirim OTP. Coba lagi.']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'whatsapp' => 'required|string|max:20',
            'otp' => 'required|string|size:6',
        ]);

        $phone = preg_replace('/[^0-9]/', '', $request->whatsapp);
        $cached = cache()->get('otp_' . $phone);

        if (!$cached || $cached['code'] !== $request->otp) {
            return response()->json(['ok' => false, 'message' => 'Kode OTP salah atau sudah expired.']);
        }

        $user = User::find($cached['user_id']);
        if (!$user) {
            return response()->json(['ok' => false, 'message' => 'User tidak ditemukan.']);
        }

        cache()->forget('otp_' . $phone);
        Auth::login($user);
        $request->session()->regenerate();

        $redirect = $user->isAdmin() ? '/admin/dashboard' : route('user.dashboard');

        return response()->json(['ok' => true, 'message' => 'Login berhasil!', 'redirect' => $redirect]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string|max:255',
        ]);

        $identifier = trim($request->identifier);

        $user = User::where('email', $identifier)->first();

        if (!$user) {
            $phone = preg_replace('/[^0-9]/', '', $identifier);
            if ($phone) {
                $user = User::where('whatsapp', 'LIKE', '%' . substr($phone, -8) . '%')->first();
            }
        }

        if (!$user) {
            return back()->with('forgot_error', 'Email/No. WhatsApp tidak terdaftar. Silahkan order di mawkost untuk mendapatkan akun.');
        }

        $upper = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $lower = 'abcdefghjkmnpqrstuvwxyz';
        $numbers = '23456789';
        $symbols = '!@#$%&*';
        $plainPassword = $upper[random_int(0, strlen($upper) - 1)]
            . $lower[random_int(0, strlen($lower) - 1)]
            . $numbers[random_int(0, strlen($numbers) - 1)]
            . $symbols[random_int(0, strlen($symbols) - 1)];
        $all = $upper . $lower . $numbers . $symbols;
        for ($i = 4; $i < 12; $i++) {
            $plainPassword .= $all[random_int(0, strlen($all) - 1)];
        }
        $plainPassword = str_shuffle($plainPassword);

        $user->update(['password' => Hash::make($plainPassword)]);

        $sent = false;

        try {
            Mail::to($user->email)->send(new SendAccountDetailsMail($user, $plainPassword));
            $sent = true;
        } catch (\Exception $e) {
        }

        if ($user->whatsapp) {
            $xsender = new XSenderService();
            if ($xsender->isEnabled()) {
                $msg = "🔐 *Reset Password mawkost*\n\n"
                    . "Halo {$user->name},\n"
                    . "Password akun mawkost kamu telah direset.\n\n"
                    . "📧 Email: {$user->email}\n"
                    . "🔑 Password Baru: {$plainPassword}\n\n"
                    . "Login di: " . url('/login') . "\n\n"
                    . "_Segera ganti password setelah login._";
                $res = $xsender->send($user->whatsapp, $msg);
                if ($res['ok']) $sent = true;
            }
        }

        if ($sent) {
            return back()->with('forgot_success', 'Password baru telah dikirim ke email/WhatsApp Anda. Silahkan cek dan login.');
        }

        return back()->with('forgot_error', 'Gagal mengirim password baru. Silahkan hubungi admin.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
