<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Laravel\Fortify\Features;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $token = Str::random(60);
            Session::put('email_verification_token', $token);
            Session::put('email_verification_email', $email);

            $verificationUrl = URL::temporarySignedRoute(
                'verify-email-with-token', now()->addMinutes(15), ['token' => $token]
            );

            Mail::to($email)->send(new EmailVerification($verificationUrl));

            return redirect()->route('verify-email')->with('verificationUrl', $verificationUrl);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showVerifyEmailForm()
    {
        return view('auth.verify-email');
    }

    public function verifyEmail(Request $request, $token)
    {
        if (! URL::hasValidSignature($request)) {
            abort(403);
        }

        $sessionToken = Session::get('email_verification_token');
        $email = Session::get('email_verification_email');

        if ($token === $sessionToken) {
            $user = User::where('email', $email)->first();

            if (Features::enabled(Features::twoFactorAuthentication()) && $user->two_factor_secret) { // Проверка на включенность 2FA

                $request->session()->put('login.id', $user->id); // Сохраняем ID для 2FA

                return redirect()->route('two-factor.login'); // Перенаправляем на страницу 2FA
            }

            Auth::login($user); // Если 2FA не включена, авторизуем сразу

            return redirect()->intended(config('fortify.home'));
        }

        return back()->withErrors([
            'token' => 'The provided token does not match.',
        ]);
    }
}
