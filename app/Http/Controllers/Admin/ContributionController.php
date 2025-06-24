<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use App\Models\Association;
use Illuminate\Http\Request;

class ContributionController extends Controller
{
    // Removed the __construct() that called authorizeResource()
    // Authorization logic will now be handled directly in Blade or manually in methods if needed.

    public function index()
    {
        // Data scoping still applies based on roles, but without policy enforcement here.
        if (auth()->user()->hasRole('superadmin')) {
            $contributions = Contribution::with('association')->latest()->get();
        } else {
            // Admin and Board can only see contributions from their own association
            $contributions = Contribution::with('association')
                                ->where('association_id', auth()->user()->association_id)
                                ->latest()
                                ->get();
        }

        return view('admin.contributions.index', compact('contributions'));
    }

    public function create()
    {
        // No explicit authorization check here without policies.
        // Frontend will be responsible for showing/hiding the button based on roles.
        $associations = auth()->user()->hasRole('superadmin')
                        ? Association::pluck('name', 'id')
                        : Association::where('id', auth()->user()->association_id)->pluck('name', 'id');

        return view('admin.contributions.create', compact('associations'));
    }

    public function store(Request $request)
    {
        // Manual authorization check would be needed here if not using policies
        // Example (simplified and less robust than a policy):
        // if (!auth()->user()->hasAnyRole(['admin', 'board', 'superadmin'])) {
        //     abort(403, 'Unauthorized action.');
        // }
        // if (!auth()->user()->hasRole('superadmin') && $request->association_id !== auth()->user()->association_id) {
        //     abort(403, 'You can only create contributions for your own association.');
        // }


        $validated = $request->validate([
            'type' => 'required|in:1,2',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'received_at' => 'nullable|date',
            'association_id' => 'required|exists:associations,id',
        ]);

        if (!auth()->user()->hasRole('superadmin')) {
            $validated['association_id'] = auth()->user()->association_id;
        }

        Contribution::create($validated);

        return redirect()->route('admin.contributions.index')->with('success', 'Contribution created successfully.');
    }

    public function show(Contribution $contribution)
    {
        // Manual authorization check would be needed here if not using policies
        // if (!auth()->user()->hasRole('superadmin') && $contribution->association_id !== auth()->user()->association_id) {
        //     abort(403, 'You can only view contributions from your own association.');
        // }

        return view('admin.contributions.show', compact('contribution'));
    }

    public function edit(Contribution $contribution)
    {
        // Manual authorization check would be needed here if not using policies
        // if (!auth()->user()->hasAnyRole(['admin', 'board', 'superadmin'])) {
        //     abort(403, 'Unauthorized action.');
        // }
        // if (!auth()->user()->hasRole('superadmin') && $contribution->association_id !== auth()->user()->association_id) {
        //     abort(403, 'You can only edit contributions for your own association.');
        // }

        $associations = auth()->user()->hasRole('superadmin')
                        ? Association::pluck('name', 'id')
                        : Association::where('id', auth()->user()->association_id)->pluck('name', 'id');

        return view('admin.contributions.edit', compact('contribution', 'associations'));
    }

    public function update(Request $request, Contribution $contribution)
    {
        // Manual authorization check would be needed here if not using policies
        // if (!auth()->user()->hasAnyRole(['admin', 'board', 'superadmin'])) {
        //     abort(403, 'Unauthorized action.');
        // }
        // if (!auth()->user()->hasRole('superadmin') && $contribution->association_id !== auth()->user()->association_id) {
        //     abort(403, 'You can only update contributions for your own association.');
        // }


        $validated = $request->validate([
            'type' => 'required|in:1,2',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'received_at' => 'nullable|date',
            'association_id' => 'required|exists:associations,id',
        ]);

        if (!auth()->user()->hasRole('superadmin')) {
            $validated['association_id'] = $contribution->association_id;
        }

        $contribution->update($validated);

        return redirect()->route('admin.contributions.index')->with('success', 'Contribution updated successfully.');
    }

    public function destroy(Contribution $contribution)
    {
        // Manual authorization check would be needed here if not using policies
        // if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('superadmin')) { // Board is excluded here
        //     abort(403, 'Unauthorized action.');
        // }
        // if (!auth()->user()->hasRole('superadmin') && $contribution->association_id !== auth()->user()->association_id) {
        //     abort(403, 'You can only delete contributions from your own association.');
        // }

        $contribution->delete();
        return redirect()->route('admin.contributions.index')->with('success', 'Contribution deleted successfully.');
    }
}
