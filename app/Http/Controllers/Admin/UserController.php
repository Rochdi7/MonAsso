<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('super_admin')) {
            $users = User::with('association')->latest()->get();
        } elseif ($user->hasRole('admin')) {
            $users = User::with('association')
                ->where('association_id', $user->association_id)
                ->latest()
                ->get();
        } else {
            abort(403);
        }

        return view('admin.membres.index', compact('users'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->hasRole('super_admin')) {
            $associations = Association::pluck('name', 'id');
        } elseif ($user->hasRole('admin')) {
            $associations = Association::where('id', $user->association_id)->pluck('name', 'id');
        } else {
            abort(403);
        }

        return view('admin.membres.create', compact('associations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6',
            'association_id' => 'required|exists:associations,id',
            'profile_photo' => 'nullable|image|max:2048',
            'assign_role' => 'required|in:admin,membre',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'availability' => $request->availability,
            'skills' => $request->skills,
            'is_active' => $request->has('is_active'),
            'association_id' => $request->association_id,
        ]);

        if ($request->hasFile('profile_photo')) {
            $shortName = substr(Str::uuid(), 0, 8) . '.' . $request->file('profile_photo')->getClientOriginalExtension();

            $media = $user->addMediaFromRequest('profile_photo')
                ->usingFileName($shortName)
                ->toMediaCollection('profile_photo');

            session()->flash('uploaded_profile_media', $media);
        }

        $user->assignRole($request->assign_role);

        return redirect()->route('admin.membres.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.membres.show', compact('user'));
    }

    public function edit(User $user)
    {
        $auth = Auth::user();

        if ($auth->hasRole('super_admin')) {
            $associations = Association::pluck('name', 'id');
        } elseif ($auth->hasRole('admin') && $user->association_id === $auth->association_id) {
            $associations = Association::where('id', $auth->association_id)->pluck('name', 'id');
        } else {
            abort(403);
        }

        return view('admin.membres.edit', compact('user', 'associations'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'association_id' => 'required|exists:associations,id',
            'profile_photo' => 'nullable|image|max:2048',
            'assign_role' => 'required|in:admin,membre',
        ]);

        $data = $request->only([
            'name',
            'email',
            'phone',
            'availability',
            'skills',
            'is_active',
            'association_id'
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if ($request->hasFile('profile_photo')) {
            $user->clearMediaCollection('profile_photo');
            $user->addMediaFromRequest('profile_photo')->toMediaCollection('profile_photo');
        }

        $user->syncRoles([$request->assign_role]);

        return redirect()->route('admin.membres.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $auth = Auth::user();

        if ($auth->hasRole('super_admin') || ($auth->hasRole('admin') && $user->association_id === $auth->association_id)) {
            $user->clearMediaCollection('profile_photo');
            $user->delete();
            return redirect()->route('admin.membres.index')->with('success', 'User deleted successfully.');
        }

        abort(403);
    }
}
