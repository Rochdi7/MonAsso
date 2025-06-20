<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Association;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Cotisation;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = $this->getUsersByRole();
        return view('admin.membres.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create', User::class);
        $associations = $this->getAssociationsByRole();
        return view('admin.membres.create', compact('associations'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $auth = Auth::user();
        $validated = $request->validated();

        if ($auth->hasRole('admin') && $validated['association_id'] != $auth->association_id) {
            abort(403, 'Unauthorized association assignment.');
        }

        $newUser = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'availability' => $request->availability,
            'skills' => $request->skills,
            'is_active' => $request->boolean('is_active'),
            'association_id' => $validated['association_id'],
        ]);

        $this->handleProfilePhoto($request, $newUser);
        $newUser->assignRole($validated['assign_role']);

        return redirect()->route('admin.membres.index')->with('success', 'User created successfully.');
    }


    public function show(User $user)
    {
        $this->authorize('view', $user);

        $cotisations = Cotisation::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('admin.membres.show', compact('user', 'cotisations'));
    }


    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $associations = $this->getAssociationsByRole();
        return view('admin.membres.edit', compact('user', 'associations'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $auth = Auth::user();
        $validated = $request->validated();

        if ($auth->hasRole('admin') && $validated['association_id'] != $auth->association_id) {
            abort(403, 'Unauthorized association change.');
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'availability' => $request->availability,
            'skills' => $request->skills,
            'is_active' => $request->boolean('is_active'),
            'association_id' => $validated['association_id'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);
        $this->handleProfilePhoto($request, $user);
        $user->syncRoles([$validated['assign_role']]);

        return redirect()->route('admin.membres.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->clearMediaCollection('profile_photo');
        $user->delete();

        return redirect()->route('admin.membres.index')->with('success', 'User deleted successfully.');
    }

    // === Helpers ===

    private function getUsersByRole()
    {
        $auth = Auth::user();

        return User::with('association')
            ->when($auth->hasRole('admin'), function ($query) use ($auth) {
                $query->where('association_id', $auth->association_id);
            })
            ->latest()
            ->get();
    }

    private function getAssociationsByRole()
    {
        $auth = Auth::user();

        return $auth->hasRole('super_admin')
            ? Association::pluck('name', 'id')
            : Association::where('id', $auth->association_id)->pluck('name', 'id');
    }

    private function handleProfilePhoto($request, $user)
    {
        if ($request->hasFile('profile_photo')) {
            $user->clearMediaCollection('profile_photo');
            $shortName = substr(Str::uuid(), 0, 8) . '.' . $request->file('profile_photo')->getClientOriginalExtension();
            $user->addMediaFromRequest('profile_photo')->usingFileName($shortName)->toMediaCollection('profile_photo');
        }
    }
}
