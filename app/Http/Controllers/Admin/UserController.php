<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Association;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        // All authenticated users with proper middleware can access
        $users = $this->getFilteredUsers();
        return view('admin.membres.index', compact('users'));
    }

    public function create()
    {
        $this->authorizeAccess();

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        $associations = $authUser->hasRole('superadmin')
            ? Association::pluck('name', 'id')
            : Association::where('id', $authUser->association_id)->pluck('name', 'id');

        $roles = $this->getAvailableRoles();

        return view('admin.membres.create', compact('associations', 'roles'));
    }

    public function store(Request $request)
    {
        $this->authorizeAccess();

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
        if (!$this->canAccessUser($user)) {
            abort(403, 'Unauthorized action.');
        }

        $cotisations = $user->cotisations()->latest()->get();

        return view('admin.membres.show', compact('user', 'cotisations'));
    }

    public function edit(User $user)
    {
        if (!$this->canAccessUser($user)) {
            abort(403, 'Unauthorized action.');
        }

        $associations = $this->getAssociationsByRole();
        $roles = $this->getAvailableRoles();

        return view('admin.membres.edit', compact('user', 'associations', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if (!$this->canAccessUser($user)) {
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

        $validRoles = $this->getAvailableRoles();
        $selectedRole = $request->assign_role;

        if (in_array($selectedRole, $validRoles)) {
            $user->syncRoles([$selectedRole]);

            // Force refresh so subsequent views show new role
            $user->refresh();

            // Optional debug
            logger()->info("User {$user->id} roles updated:", $user->getRoleNames()->toArray());
        } else {
            return back()->with('error', 'Invalid role selected');
        }

        return redirect()->route('admin.membres.index')
            ->with('success', 'User updated successfully.');
    }


    public function destroy(User $user)
    {
        if (!$this->canAccessUser($user)) {
            abort(403, 'Unauthorized action.');
        }

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
        /** @var \App\Models\User $auth */
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
        /** @var \App\Models\User $auth */
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
            $roles = array_merge($roles, ['admin', 'board']);
        }

        return $roles;
    }

    private function handleProfilePhoto($request, $user)
    {
        if ($request->hasFile('profile_photo')) {
            $user->clearMediaCollection('profile_photo');
            $shortName = substr(Str::uuid(), 0, 8) . '.' . $request->file('profile_photo')->getClientOriginalExtension();
            $user->addMediaFromRequest('profile_photo')
                ->usingFileName($shortName)
                ->toMediaCollection('profile_photo');
        }
    }

    private function canAccessUser(User $user): bool
    {
        /** @var \App\Models\User $auth */
        $auth = Auth::user();

        if ($auth->hasRole('superadmin')) {
            return true;
        }

        return $auth->association_id === $user->association_id;
    }

    private function authorizeAccess()
    {
        /** @var \App\Models\User $auth */
        $auth = Auth::user();

        if (!$auth->hasAnyRole(['superadmin', 'admin', 'board', 'supervisor'])) {
            abort(403, 'Unauthorized action.');
        }
    }
}
