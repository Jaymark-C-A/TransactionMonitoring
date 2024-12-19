<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        try {
            // Attempt to send the password reset link to the user.
            $status = Password::sendResetLink(
                $request->only('email')
            );

            // Check the status and return the appropriate response.
            return $status == Password::RESET_LINK_SENT
                ? back()->with('status', __($status))
                : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
        } catch (\Exception $e) {
            // Log the exception for debugging purposes.
            Log::error('Password reset link sending failed: ' . $e->getMessage());

            // Return an error message to the user.
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => __('Network is not available. Please try again later.')]);
        }
    }
}
