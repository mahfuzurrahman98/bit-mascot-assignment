<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\SendOTP;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\VerificationCode;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller {
    /**
     * Show the login form
     *
     * Removes any existing email from the session and returns the login view
     *
     * @return \Illuminate\View\View
     */
    public function login(): View {
        // Remove any existing email from the session
        session()->forget('email');
        // Return the login view
        return view('auth.login');
    }


    /**
     * Authenticate the user.
     * 
     * If the user is an admin, authenticate them directly.
     * Otherwise, validate their credentials without logging them in
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(LoginRequest $request): RedirectResponse {
        try {
            // Check if a user with the given email exists
            $user = User::where('email', $request->email)->first();

            // If no user exists, return back with an error
            if (!$user) {
                return back()
                    ->withError('Invalid credentials')
                    ->withInput($request->only('email'));
            }

            // If the user is an admin, authenticate them directly
            if ($user->role == 1) {
                // Attempt to authenticate the user
                if (!Auth::attempt($request->only('email', 'password'))) {
                    return back()
                        ->withError('Invalid credentials')
                        ->withInput($request->only('email'));
                }

                // Regenerate the session to prevent session fixation attacks
                $request->session()->regenerate();
                // Redirect the user to their intended location, or to the profile page if no intended location is set
                return redirect()->intended('profile');
            } else {
                // If the user is not an admin, validate their credentials without logging them in
                if (!Auth::guard()->validate($request->only('email', 'password'))) {
                    return back()
                        ->withError('Invalid credentials')
                        ->withInput($request->only('email'));
                }
                // Generate a random OTP
                $otp = rand(100000, 999999);
                // Store the OTP in the database
                VerificationCode::create([
                    'email' => $user->email,
                    'otp' => $otp
                ]);

                // Store the email in the session
                $request->session()->put('email', $user->email);

                // Send the OTP via email
                Mail::to($user->email)->send(new SendOTP($otp));

                // Redirect the user to the OTP form
                return redirect()->route('email.form');
            }
        } catch (Exception $e) {
            // If an exception occurs, return back with the exception message
            return back()
                ->withError($e->getMessage())
                ->withInput($request->only('email'));
        }
    }


    /**
     * Show the OTP form
     * 
     * First check if an email is in the session.
     * If no email is in the session, or if no user with the given email exists, redirect to the login page
     *
     * @return \Illuminate\View\View
     */
    public function showEmailVerificationForm(): View {
        // Get the email from the session
        $email = session()->get('email');
        // If no email is in the session, or if no user with the given email exists, redirect to the login page
        if (!$email || User::where('email', $email)->doesntExist()) {
            return redirect()->route('login');
        }
        // Return the OTP form view
        return view('auth.email-verification');
    }


    /**
     * Verify the OTP
     * 
     * If the OTP is valid, log the user in.
     * Otherwise, return back with an errors
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEmail(Request $request): RedirectResponse {
        // If no OTP is provided, return back with an error
        if (!$request->has('otp') || trim($request->otp) == '') {
            return back()->withErrors(['otp' => 'Code is required']);
        }

        // Get the email from the session
        $email = $request->session()->get('email');

        // Get the most recent OTP for the given email
        $verificationCode = VerificationCode::where('email', $email)->latest()->first();
        // If no OTP exists, or if the provided OTP does not match the stored OTP, return back with an error
        if (!$verificationCode || $verificationCode->otp != $request->otp) {
            return back()->withErrors(['otp' => 'The code is invalid']);
        }

        // Remove the email from the session
        $request->session()->forget('email');

        // Get the user with the given email
        $user = User::where('email', $email)->first();

        // Log the user in
        Auth::login($user);
        // Redirect the user to the profile page with a success message
        return redirect()->route('profile')->withSuccess('You are logged in!');
    }



    /**
     * Show the profile page
     *
     * @return \Illuminate\View\View
     */
    public function profile(): View {
        return view('auth.profile');
    }


    /**
     * Show the password update form
     *
     * @return \Illuminate\View\View
     */
    public function showPasswordForm(): View {
        return view('auth.password');
    }


    /**
     * Update the user's password
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request): RedirectResponse {
        // Validate the request data
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        // Get the currently authenticated user
        $user = Auth::user();
        // If the provided old password matches the user's current password, update the password
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
            // Redirect the user to the profile page with a success message
            return redirect()->route('profile')->withSuccess('Your password has been updated!');
        } else {
            // If the provided old password does not match the user's current password, return back with an error
            return back()->withErrors(['old_password' => 'The old password is incorrect']);
        }
    }


    /**
     * Log the user out
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse {
        Auth::logout();
        // Invalidate the session
        $request->session()->invalidate();
        // Regenerate the CSRF token to prevent CSRF attacks
        $request->session()->regenerateToken();
        // Redirect the user to the home page
        return redirect('/');
    }
}
