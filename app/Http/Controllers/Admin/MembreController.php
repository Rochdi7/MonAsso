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
            'association_id' => 'required|exists:associations,id',
            'profile_photo' => 'nullable|image|max:2048',
            'assign_role' => 'required|in:super_admin,admin,membre',
        ]);

        $membre = Membre::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'availability' => $request->availability,
            'skills' => $request->skills,
            'is_active' => $request->has('is_active'),
            'association_id' => $request->association_id,
        ]);

        if ($request->hasFile('profile_photo')) {
            $shortName = substr(Str::uuid(), 0, 8) . '.' . $request->file('profile_photo')->getClientOriginalExtension();

            $media = $membre->addMediaFromRequest('profile_photo')
                ->usingFileName($shortName)
                ->toMediaCollection('profile_photo');

            session()->flash('uploaded_profile_media', $media);
        }

        $membre->assignRole($request->assign_role);

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
            'association_id' => 'required|exists:associations,id',
            'profile_photo' => 'nullable|image|max:2048',
            'assign_role' => 'required|in:super_admin,admin,membre',
        ]);

        $data = $request->only([
            'name',
            'phone',
            'availability',
            'skills',
            'is_active',
            'association_id'
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $membre->update($data);

        if ($request->hasFile('profile_photo')) {
            $membre->clearMediaCollection('profile_photo');
            $membre->addMediaFromRequest('profile_photo')->toMediaCollection('profile_photo');
        }

        // Update role via Spatie
        $membre->syncRoles([$request->assign_role]);

        return redirect()->route('admin.membres.index')->with('success', 'Membre updated successfully.');
    }

    public function destroy(Membre $membre)
    {
        $membre->clearMediaCollection('profile_photo');
        $membre->delete();
        return redirect()->route('admin.membres.index')->with('success', 'Membre deleted successfully.');
    }
}
