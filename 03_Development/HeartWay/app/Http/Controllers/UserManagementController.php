<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserManagementController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'superadmin') {
            $users = User::where('role', 'school_admin')->get();
            $viewType = 'admins';
        } else {
            $users = User::where('role', 'parent')->get();
            $viewType = 'parents';
        }

        return view('users.index', compact('users', 'viewType'));
    }

    public function create()
    {
        $user = auth()->user();
        $roleToCreate = $user->role === 'superadmin' ? 'school_admin' : 'parent';

        return view('users.create', compact('roleToCreate'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $roleToCreate = $user->role === 'superadmin' ? 'school_admin' : 'parent';

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $roleToCreate,
        ]);

        $label = $roleToCreate === 'school_admin' ? 'Admin' : 'Parent';
        return redirect()->route('users.index')->with('success', "$label created successfully.");
    }

    public function destroy(User $user)
    {
        $currentUser = auth()->user();

        if ($currentUser->role === 'superadmin' && $user->role !== 'school_admin') {
            session()->flash('error', 'You can only delete admins.');
            return redirect()->route('users.index');
        }

        if ($currentUser->role === 'school_admin' && $user->role !== 'parent') {
            session()->flash('error', 'You can only delete parents.');
            return redirect()->route('users.index');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
