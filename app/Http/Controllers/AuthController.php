<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json(['success' => true, 'message' => 'Logged in successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid email or password.'], 401);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        // Generate a 4-digit verification OTP
        $otp = rand(1000, 9999);

        // Store OTP and pending registration data in session
        session([
            'register_otp' => $otp,
            'register_user' => [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]
        ]);

        // Send OTP email (written to storage/logs/laravel.log)
        Mail::raw("Your Ocean Ecom VIP registration verification code is: {$otp}\n\nPlease enter this code on the verification page to complete your registration.", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Ocean Ecom VIP Verification Code');
        });

        return response()->json([
            'success' => true, 
            'message' => 'Verification code sent to your email! (Please inspect storage/logs/laravel.log to find your OTP code).'
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:4'],
        ]);

        $sessionOtp = session('register_otp');
        $userData = session('register_user');

        if (!$sessionOtp || !$userData) {
            return response()->json(['success' => false, 'message' => 'Session expired or invalid request. Please register again.'], 422);
        }

        if ($request->otp == $sessionOtp) {
            // Create user in database
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
            ]);

            // Log user in
            Auth::login($user);

            // Clear session data
            session()->forget(['register_otp', 'register_user']);

            return response()->json(['success' => true, 'message' => 'Account verified and logged in successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid verification code. Please check your log file.'], 422);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth');
    }
}
