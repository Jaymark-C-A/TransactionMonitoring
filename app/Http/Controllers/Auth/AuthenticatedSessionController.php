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

        $request->session()->regenerate();

        // return redirect()->intended(RouteServiceProvider::HOME);

        // Check if the authenticated user has a role that should be redirected to a specific dashboard
        if (Auth::user()->hasRole('Super-admin')) {
        // Redirect admin users to the admin dashboard
        return redirect()->route('super-admin.dashboard');
    }   else if (Auth::user()->hasRole('Guard'))  { /// Guard
        // Redirect regular users to the default dashboard
        return redirect()->route('admin-guard.dashboard');
    }   else if (Auth::user()->hasRole('Principal'))  {
        // Redirect regular users to the default dashboard
        return redirect()->route('super-admin.dashboard');
    }   else if (Auth::user()->hasRole('Department_Head'))  {
        // Redirect regular users to the default dashboard
        return redirect()->route('department-head.dashboard');
    }   else if (Auth::user()->hasRole('Records'))  {
        // Redirect regular users to the default dashboard
        return redirect()->route('records.dashboard');
    }   else if (Auth::user()->hasRole('Accounting'))  {
        // Redirect regular users to the default dashboard
        return redirect()->route('accounting.dashboard');
    }   else if (Auth::user()->hasRole('Admin'))  {
        // Redirect regular users to the default dashboard
        return redirect()->route('admin.dashboard');
    }   else {
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
