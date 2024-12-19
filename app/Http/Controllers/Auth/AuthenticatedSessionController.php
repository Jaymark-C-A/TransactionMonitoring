<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
    
        // Check if the authenticated user is archived
        if (Auth::user()->is_archived) {
            Auth::logout();  // Log out the archived user
            return redirect()->route('login.view')->withErrors(['Your account is archived and cannot be accessed.']);
        }
    
        $request->session()->regenerate();
    
        // Redirect based on the user's role
        if (Auth::user()->hasRole('Super-admin')) {
            return redirect()->route('super-admin.dashboard');
        } elseif (Auth::user()->hasRole('Guard')) {
            return redirect()->route('admin-guard.dashboard');
        } elseif (Auth::user()->hasRole('Clinic')) {
            return redirect()->route('clinic.dashboard');
        } elseif (Auth::user()->hasRole('Guidance')) {
            return redirect()->route('guidance.dashboard');
        } elseif (Auth::user()->hasRole('Records')) {
            return redirect()->route('records.dashboard');
        } elseif (Auth::user()->hasRole('Accounting')) {
            return redirect()->route('accounting.dashboard');
        } elseif (Auth::user()->hasRole('Admin')) {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->hasRole('Principal')) {
            return redirect()->route('TransactionMonitoring.dashboard');
        } else {
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }
    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
