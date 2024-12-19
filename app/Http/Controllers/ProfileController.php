<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function uploadProfilePicture(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if (Auth::user()->profile_picture) {
                Storage::disk('public')->delete(Auth::user()->profile_picture);
            }
        
            // Store the new file and update the profile picture path
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            Auth::user()->update(['profile_picture' => $profilePicturePath]);
            return redirect()->back()->with('success', 'Profile picture uploaded successfully.');
        }
        // If no file was uploaded, return an error message
        return redirect()->back()->with('error', 'No file selected. Please choose an image to upload.');
    }
    public function show($id, $view): View
    {
        $user = User::findOrFail($id);
        return view($view, compact('user'));
    }
    public function showSuperAdminProfile($id): View
    {
        return $this->show($id, 'super-admin.profile');
    }
    public function showPrincipalProfile($id): View
    {
        return $this->show($id, 'principal.profile');
    }
    public function showAdminGuardProfile($id): View
    {
        return $this->show($id, 'admin-guard.profile');
    }
    public function showHeadProfile($id): View
    {
        return $this->show($id, 'department-head.profile');
    }
    public function showAdminProfile($id): View
    {
        return $this->show($id, 'admin.profile');
    }
    public function showAccountingProfile($id): View
    {
        return $this->show($id, 'accounting.profile');
    }
    public function showAdminGushowRecordProfileardProfile($id): View
    {
        return $this->show($id, 'records.dashboard');
    }
    public function edit(Request $request): View
    {
        $users = User::all();
        return view('super-admin.dashboard', [
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
        } elseif ($user->hasRole('Principal') || $user->hasRole('Department_Head') || $user->hasRole('Records') || $user->hasRole('Admin')) {
            return redirect()->route('profile.offices', $user->id);
        } else {
            return redirect()->route('profile.super-admin', $user->id);
        }
    }
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        // Update the employee_no if provided
        if ($request->has('employee_no')) {
            $request->user()->employee_no = $request->input('employee_no');
        }
        $request->user()->save();
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
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
