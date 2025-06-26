<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Association;
use App\Models\Cotisation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = $this->getFilteredUsers();
        return view('admin.membres.index', compact('users'));
    }

    public function create()
    {
        $authUser = auth()->user();

        $associations = $authUser->hasRole('superadmin')
            ? \App\Models\Association::pluck('name', 'id')
            : \App\Models\Association::where('id', $authUser->association_id)->pluck('name', 'id');

        $roles = ['supervisor', 'admin', 'board', 'member'];

        return view('admin.membres.create', compact('associations', 'roles'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
            'association_id' => 'required|exists:associations,id',
            'assign_role' => 'required|string',
        ]);

        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'availability' => $request->availability,
            'skills' => $request->skills,
            'is_active' => $request->boolean('is_active'),
            'association_id' => $request->association_id,
        ]);

        $this->handleProfilePhoto($request, $newUser);

        // Validate role before assigning
        $validRoles = $this->getAvailableRoles();
        if (in_array($request->assign_role, $validRoles)) {
            $newUser->assignRole($request->assign_role);
        } else {
            return back()->with('error', 'Invalid role selected');
        }

        return redirect()->route('admin.membres.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        if (!$this->canViewUser($user)) {
            abort(403, 'Unauthorized action.');
        }

        $cotisations = $user->cotisations()->latest()->get();

        return view('admin.membres.show', compact('user', 'cotisations'));
    }

    public function edit(User $user)
    {
        // Check if the current user is authorized to edit this user
        if (!$this->canViewUser($user)) {
            abort(403, 'Unauthorized action.');
        }

        $associations = $this->getAssociationsByRole();
        $roles = $this->getAvailableRoles();

        return view('admin.membres.edit', compact('user', 'associations', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Check if the current user is authorized to update this user
        if (!$this->canViewUser($user)) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'association_id' => 'required|exists:associations,id',
            'assign_role' => 'required|string',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'availability' => $request->availability,
            'skills' => $request->skills,
            'is_active' => $request->boolean('is_active'),
            'association_id' => $request->association_id,
        ];

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $this->handleProfilePhoto($request, $user);

        // Validate and sync the role
        $validRoles = $this->getAvailableRoles();
        $selectedRole = $request->assign_role;

        if (in_array($selectedRole, $validRoles)) {
            $user->syncRoles([$selectedRole]);
        } else {
            return back()->with('error', 'Invalid role selected');
        }

        return redirect()->route('admin.membres.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Check if the current user is authorized to delete this user
        if (!$this->canViewUser($user)) {
            abort(403, 'Unauthorized action.');
        }

        // Check if user has 'board' role
        if ($user->hasRole('board')) {
            return redirect()->route('admin.membres.index')
                ->with('error', 'Cannot delete users with board role');
        }

        $user->clearMediaCollection('profile_photo');
        $user->delete();

        return redirect()->route('admin.membres.index')
            ->with('success', 'User deleted successfully.');
    }

    // === Helpers ===

    private function getFilteredUsers()
    {
        $auth = Auth::user();

        return User::with('association')
            ->when(!$auth->hasRole('superadmin'), function ($query) use ($auth) {
                $query->where('association_id', $auth->association_id);
            })
            ->latest()
            ->get();
    }

    private function getAssociationsByRole()
    {
        $auth = Auth::user();

        return $auth->hasRole('superadmin')
            ? Association::pluck('name', 'id')
            : Association::where('id', $auth->association_id)->pluck('name', 'id');
    }

    private function getAvailableRoles()
    {
        $auth = Auth::user();
        $roles = ['member', 'supervisor'];

        if ($auth->hasRole('superadmin')) {
            $roles = array_merge($roles, ['admin', 'board', 'superadmin']);
        } elseif ($auth->hasRole('admin')) {
            $roles[] = 'admin';
        }

        return $roles;
    }

    private function handleProfilePhoto($request, $user)
    {
        if ($request->hasFile('profile_photo')) {
            $user->clearMediaCollection('profile_photo');
            $shortName = substr(Str::uuid(), 0, 8) . '.' . $request->file('profile_photo')->getClientOriginalExtension();
            $user->addMediaFromRequest('profile_photo')->usingFileName($shortName)->toMediaCollection('profile_photo');
        }
    }

    private function canViewUser(User $user)
    {
        $auth = Auth::user();

        // Super admin can view any user
        if ($auth->hasRole('superadmin')) {
            return true;
        }

        // Other users can only view users from their own association
        return $auth->association_id === $user->association_id;
    }
}