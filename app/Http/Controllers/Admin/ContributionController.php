<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use App\Models\Association;
use Illuminate\Http\Request;

class ContributionController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('superadmin')) {
            $contributions = Contribution::with('association')->latest()->get();
        } else {
            $contributions = Contribution::with('association')
                ->where('association_id', auth()->user()->association_id)
                ->latest()
                ->get();
        }

        return view('admin.contributions.index', compact('contributions'));
    }

    public function create()
    {
        $user = auth()->user()->load('association');

        $associations = $user->hasRole('superadmin')
            ? Association::pluck('name', 'id')
            : collect();

        return view('admin.contributions.create', [
            'authUser' => $user,
            'associations' => $associations,
        ]);
    }


    public function store(Request $request)
    {
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
        return view('admin.contributions.show', compact('contribution'));
    }

    public function edit(Contribution $contribution)
    {
        $user = auth()->user()->load('association');

        $associations = $user->hasRole('superadmin')
            ? Association::pluck('name', 'id')
            : collect(); 

        return view('admin.contributions.edit', [
            'contribution' => $contribution,
            'authUser' => $user,
            'associations' => $associations,
        ]);
    }


    public function update(Request $request, Contribution $contribution)
    {
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
        $contribution->delete();

        return redirect()->route('admin.contributions.index')->with('success', 'Contribution deleted successfully.');
    }
}
