<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function uploadProfilePicture(Request $request)
{
    $request->validate([
        'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
    ]);

    $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');

    auth()->user()->update(['profile_picture' => $profilePicturePath]);

    return redirect()->back()->with('success', 'Profile picture uploaded successfully.');
}


    public function show($id, $view)
    {
        $user = User::findOrFail($id);
        return view($view, compact('user'));
    }

    public function showSuperAdminProfile($id)
    {
        return $this->show($id, 'super-admin.profile');
    }

    public function showOfficeProfile($id)
    {
        return $this->show($id, 'offices.profile');
    }

    public function showAdminGuardProfile($id)
    {
        return $this->show($id, 'admin-guard.profile');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $users = User::get();
        return view('/super-admin.profile', [
            'users' => $users,
            'user' => $request->user(),
        ]);
    }

    public function edits()
    {
        $user = Auth::user();
        if ($user->hasRole('Super-admin')) {
            return redirect()->route('profile.super-admin', $user->id);
        } elseif ($user->hasRole('Guard')) {
            return redirect()->route('profile.admin', $user->id);
        } elseif ($user->hasRole('Principal')) {
            return redirect()->route('profile.offices', $user->id);
        } elseif ($user->hasRole('Department_Head')) {
            return redirect()->route('profile.offices', $user->id);
        } elseif ($user->hasRole('Records')) {
            return redirect()->route('profile.offices', $user->id);
        } elseif ($user->hasRole('Admin')) {
            return redirect()->route('profile.offices', $user->id);
        } else {
            return redirect()->route('profile.super-admin', $user->id);
        }
    }

    /**
     * Update the user's profile information.
     */
public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $request->user()->fill($request->validated());

    if ($request->user()->isDirty('email')) {
        $request->user()->email_verified_at = null;
    }

    // Add the employee_no to be updated
    if ($request->has('employee_no')) {
        $request->user()->employee_no = $request->input('employee_no');
    }

    $request->user()->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/super-admin.dashboard');
    }
}
