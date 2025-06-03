<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AssociationController extends Controller
{
    public function index()
    {
        $associations = Association::latest()->get();
        return view('admin.associations.index', compact('associations'));
    }

    public function create()
    {
        return view('admin.associations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'email' => 'required|email|unique:associations,email',
            'logo' => 'nullable|image',
            'announcement_status' => 'nullable|string',
            'creation_date' => 'nullable|date',
            'is_validated' => 'nullable|boolean',
        ]);

        $validated['id'] = Str::uuid();
        $validated['is_validated'] = $request->has('is_validated');
        $validated['validation_date'] = $request->has('is_validated') ? now() : null;


        $validated['id'] = Str::uuid();

        $association = Association::create($validated);

        if ($request->hasFile('logo')) {
            $shortName = substr(Str::uuid(), 0, 8) . '.' . $request->file('logo')->getClientOriginalExtension();

            $association
                ->addMediaFromRequest('logo')
                ->usingFileName($shortName)
                ->toMediaCollection('logos');
        }

        return redirect()->route('admin.associations.index')->with('success', 'Association created successfully.');
    }

    public function edit(Association $association)
    {
        return view('admin.associations.edit', compact('association'));
    }

    public function update(Request $request, Association $association)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'email' => 'required|email|unique:associations,email,' . $association->id,
            'logo' => 'nullable|image',
            'announcement_status' => 'nullable|string',
            'creation_date' => 'nullable|date',
            'is_validated' => 'nullable|boolean',
        ]);

        $validated['is_validated'] = $request->has('is_validated');
        $validated['validation_date'] = $request->has('is_validated') ? now() : null;


        $association->update($validated);

        if ($request->hasFile('logo')) {
            $association->clearMediaCollection('logos');

            $shortName = substr(Str::uuid(), 0, 8) . '.' . $request->file('logo')->getClientOriginalExtension();

            $association
                ->addMediaFromRequest('logo')
                ->usingFileName($shortName)
                ->toMediaCollection('logos');
        }

        return redirect()->route('admin.associations.index')->with('success', 'Association updated successfully.');
    }

    public function destroy(Association $association)
    {
        $association->clearMediaCollection('logos');
        $association->delete();

        return redirect()->route('admin.associations.index')->with('success', 'Association deleted.');
    }
}
