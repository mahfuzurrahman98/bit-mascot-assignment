<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\SendOTP;
use Illuminate\Http\Request;
use App\Models\VerificationCode;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function login() {
        // remove the email from session
        session()->forget('email');
        return view('auth.login');
    }

    public function authenticate(LoginRequest $request): RedirectResponse {
        try {
            // check if user is an admin
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()
                    ->withError('Invalid credentials')
                    ->withInput($request->only('email'));
            }

            if ($user->role == 1) {
                // the user is an admin
                // we can authenticate him/her directly
                if (!Auth::attempt($request->only('email', 'password'))) {
                    return back()
                        ->withError('Invalid credentials')
                        ->withInput($request->only('email'));
                }

                $request->session()->regenerate();
                return redirect()->intended('profile');
            } else {
                // user is not an admin
                // first check the credentials is valid
                if (!Auth::guard()->validate($request->only('email', 'password'))) {
                    return back()
                        ->withError('Invalid credentials')
                        ->withInput($request->only('email'));
                }
                // we have to authenticate him/her by sending OTP
                $otp = rand(100000, 999999);
                VerificationCode::create([
                    'email' => $user->email,
                    'otp' => $otp
                ]);

                // put the email in session
                $request->session()->put('email', $user->email);

                Mail::to($user->email)->send(new SendOTP($otp));

                return redirect()->route('email.form');
            }
        } catch (Exception $e) {
            return back()
                ->withError($e->getMessage())
                ->withInput($request->only('email'));
        }
    }

    public function showEmailVerificationForm() {
        $email = session()->get('email');
        if (!$email || User::where('email', $email)->doesntExist()) {
            return redirect()->route('login');
        }
        return view('auth.email-verification');
    }

    public function verifyEmail(Request $request) {
        if (!$request->has('otp') || trim($request->otp) == '') {
            return back()->withErrors(['otp' => 'Code is required']);
        }

        $email = $request->session()->get('email');

        // get the recent one
        $verificationCode = VerificationCode::where('email', $email)->latest()->first();
        if (!$verificationCode || $verificationCode->otp != $request->otp) {
            return back()->withErrors(['otp' => 'The code is invalid']);
        }


        $request->session()->forget('email');

        // get the user
        $user = User::where('email', $email)->first();

        // authenticate the user
        Auth::login($user);
        return redirect()->route('profile')->withSuccess('You are logged in!');
    }

    public function profile(Request $request) {
        return view('auth.profile');
    }

    public function showPasswordForm() {
        return view('auth.password');
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('profile')->withSuccess('Your password has been updated!');
        } else {
            return back()->withErrors(['old_password' => 'The old password is incorrect']);
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
