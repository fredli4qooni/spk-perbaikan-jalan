<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Mail\LoginNotification;
use App\Mail\PasswordChangedNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            ActivityLogger::log('login', "Pengguna {$user->name} ({$user->email}) berhasil login");

            try {
                Mail::to($user->email)->send(new LoginNotification($user, $request->ip(), $request->userAgent()));
            } catch (\Exception $e) {
                // Ignore mail delivery failure on local environments without SMTP configured
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            ActivityLogger::log('logout', "Pengguna {$user->name} logout");
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function showProfileForm()
    {
        return view('profile.edit');
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        $user->update($data);

        ActivityLogger::log('profile', "Memperbarui data identitas profil ({$data['name']} / {$data['email']})");

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan.',
            ])->onlyInput('email');
        }

        if ($user->role === 'admin') {
            return back()->withErrors([
                'email' => 'Akun admin tidak diizinkan mereset password melalui halaman ini. Silakan hubungi pengembang sistem.',
            ])->onlyInput('email');
        }

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        ActivityLogger::log('password', "Mereset kata sandi akun melalui formulir Lupa Password", $user->id);

        try {
            Mail::to($user->email)->send(new PasswordChangedNotification($user, 'Formulir Lupa Password', $request->ip()));
        } catch (\Exception $e) {
            // Ignore mail transport errors gracefully
        }

        return redirect()->route('login')->with('success', 'Password berhasil diperbarui dan notifikasi konfirmasi telah dikirim ke email Anda. Silakan login kembali.');
    }
}
