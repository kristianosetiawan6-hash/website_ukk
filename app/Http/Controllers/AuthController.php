<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $identifier = trim($credentials['identifier']);
        $normalizedIdentifier = mb_strtolower($identifier);
        $throttleKey = $normalizedIdentifier.'|'.$request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return back()->withErrors([
                'identifier' => 'Terlalu banyak percobaan. Coba lagi dalam '.RateLimiter::availableIn($throttleKey).' detik.',
            ])->onlyInput('identifier');
        }

        $email = filter_var($normalizedIdentifier, FILTER_VALIDATE_EMAIL)
            ? $normalizedIdentifier
            : 'user+'.hash('sha256', $normalizedIdentifier).'@accounts.ruanggaji.invalid';
        $user = User::where('email', $email)->first();

        if ($user && ! Hash::check($credentials['password'], $user->password)) {
            RateLimiter::hit($throttleKey, 60);

            return back()->withErrors(['identifier' => 'Kata sandi tidak sesuai untuk identitas ini.'])
                ->onlyInput('identifier');
        }

        if (! $user) {
            $creationKey = 'new-user|'.$request->ip();
            if (RateLimiter::tooManyAttempts($creationKey, 10)) {
                return back()->withErrors([
                    'identifier' => 'Batas pembuatan akun sementara tercapai. Coba lagi dalam '.RateLimiter::availableIn($creationKey).' detik.',
                ])->onlyInput('identifier');
            }

            $displayName = $identifier;
            if (filter_var($normalizedIdentifier, FILTER_VALIDATE_EMAIL)) {
                $emailName = Str::before($identifier, '@');
                $emailName = Str::before($emailName, '+');
                $displayName = Str::title(str_replace(['.', '_', '-'], ' ', $emailName));
            }

            $user = User::create([
                'name' => mb_substr($displayName, 0, 255),
                'email' => $email,
                'password' => $credentials['password'],
                'role' => 'user',
            ]);
            RateLimiter::hit($creationKey, 60);
        }

        Auth::login($user, $request->boolean('remember'));
        RateLimiter::clear($throttleKey);
        $request->session()->forget('guest_mode');
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            ...$validated,
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->forget('guest_mode');
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function continueAsGuest(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $request->session()->put('guest_mode', true);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function exitGuest(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}