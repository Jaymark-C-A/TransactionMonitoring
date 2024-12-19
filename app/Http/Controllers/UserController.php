<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('role-permission.user.index', [
            'users' => $users
        ]);
    }
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('role-permission.user.create', [
            'roles' => $roles
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'empployee_no' => 'nullable',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/^[^\'\"\\\\]+$/', // Disallow single quotes, double quotes, and backslashes
            ],
            'roles' => 'required',
            'roles.*' => 'string|in:Guard,Principal,Department_Head,Records,Accounting,Admin', // Adjust as necessary
        ], [
            'password.regex' => 'The password cannot contain single quotes, double quotes, or backslashes.', // Custom error message
        ]);
        
        $user = User::create([
            'empployee_no' => $request->empployee_no,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        $user->syncRoles($request->roles);
        
        return redirect('/users')->with('status', 'User created successfully with roles.');            
    }
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        return view('role-permission.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255,' . $user->id, // Allow current email
        ]);
    
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
    
        // Uncomment if you want to allow password updates
        // if (!empty($request->password)) {
        //     $data['password'] = Hash::make($request->password);
        // }
    
        $user->update($data);
        // $user->syncRoles($request->roles);
        return redirect('/users')->with('status', 'User Updated Successfully');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deletion of super-admin
        if ($user->hasRole('Super-admin')) {
            return redirect()->back()->with('error', 'You cannot delete the super-admin user.');
        }
        $user->delete();
        return redirect()->back()->with('status', 'User deleted successfully.');
    }
    public function showArchivedUsers()
    {
        // Fetch archived users using the 'is_archived' column
        $users = User::where('is_archived', true)->get();  // Adjust query to fetch archived users
        return view('super-admin.archive', compact('users'));  // Pass users to the view
    }
    public function archive($id)
    {
        $user = User::findOrFail($id);
        $user->is_archived = true;  // Set 'is_archived' to true
        $user->save();
        return redirect()->route('users.archived')->with('status', 'User archived successfully');
    }
    public function restore($id)
    {
        $user = User::findOrFail($id);
        $user->is_archived = false;  // Set 'is_archived' to false to restore
        $user->save();
        return redirect()->route('users.index')->with('status', 'User restored successfully');
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();  // Permanently delete the user
        return redirect()->route('users.archived')->with('status', 'User deleted permanently');
    }
}
