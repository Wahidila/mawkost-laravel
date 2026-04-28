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
