<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\LoginAttempted; // Import your custom event
use App\Models\LoginAttempt;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $loginAttempt = LoginAttempt::where('email', $request->email)->first();
        if ($loginAttempt && $loginAttempt->locked_until > Carbon::now()) {
            return response()->json([
                'message' => 'Too many login attempts. Please wait for 1 minute.',
                'wait_time' => $loginAttempt->locked_until->diffInSeconds(),
            ], 429);
        }
        $success = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        event(new LoginAttempted($request->email, $success));
        if ($success) {
            return response()->json(['message' => 'Login successful']);
        } else {
            return response()->json(['message' => 'Invalid credentials.']);
        }
    }
}
