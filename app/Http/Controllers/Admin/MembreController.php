<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MembreController extends Controller
{
    public function index()
    {
        $membres = Membre::with('association')->latest()->get();
        return view('admin.membres.index', compact('membres'));
    }

    public function create()
    {
        $associations = Association::pluck('name', 'id');
        return view('admin.membres.create', compact('associations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:members,phone',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,membre,super_admin',
            'association_id' => 'required|exists:associations,id',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $membre = Membre::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'availability' => $request->availability,
            'skills' => $request->skills,
            'is_active' => $request->has('is_active'),
            'is_admin' => $request->has('is_admin'),
            'association_id' => $request->association_id,
        ]);

        if ($request->hasFile('profile_photo')) {
            $membre->addMediaFromRequest('profile_photo')->toMediaCollection('profile_photo');
        }

        return redirect()->route('admin.membres.index')->with('success', 'Membre created successfully.');
    }

    public function show(Membre $membre)
    {
        return view('admin.membres.show', compact('membre'));
    }

    public function edit(Membre $membre)
    {
        $associations = Association::pluck('name', 'id');
        return view('admin.membres.edit', compact('membre', 'associations'));
    }

    public function update(Request $request, Membre $membre)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:members,phone,' . $membre->id,
            'role' => 'required|in:admin,membre,super_admin',
            'association_id' => 'required|exists:associations,id',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'name', 'phone', 'role', 'availability', 'skills',
            'is_active', 'is_admin', 'association_id'
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $membre->update($data);

        if ($request->hasFile('profile_photo')) {
            $membre->clearMediaCollection('profile_photo');
            $membre->addMediaFromRequest('profile_photo')->toMediaCollection('profile_photo');
        }

        return redirect()->route('admin.membres.index')->with('success', 'Membre updated successfully.');
    }

    public function destroy(Membre $membre)
    {
        $membre->clearMediaCollection('profile_photo'); 
        $membre->delete();
        return redirect()->route('admin.membres.index')->with('success', 'Membre deleted successfully.');
    }
}
