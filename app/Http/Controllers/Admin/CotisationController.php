<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cotisation;
use App\Models\User;
use App\Models\Association;
use Illuminate\Http\Request;

class CotisationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            $cotisations = Cotisation::with(['user', 'association'])->latest()->get();
        } elseif ($user->hasRole('admin')) {
            $cotisations = Cotisation::with(['user', 'association'])
                ->where('association_id', $user->association_id)
                ->latest()->get();
        } elseif ($user->hasRole('membre')) {
            $cotisations = Cotisation::with('association')
                ->where('user_id', $user->id)
                ->latest()->get();
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.cotisations.index', compact('cotisations'));
    }

    public function create(Request $request)
    {
        $this->authorize('create cotisation');
        $authUser = auth()->user();
        $selectedUserId = $request->get('user_id');

        if ($authUser->hasRole('super_admin')) {
            $users = User::all();
            $associations = Association::all();
        } elseif ($authUser->hasRole('admin')) {
            $users = User::where('association_id', $authUser->association_id)->get();
            $associations = Association::where('id', $authUser->association_id)->get();
        } else {
            abort(403, 'Unauthorized');
        }

        if ($selectedUserId && !$users->pluck('id')->contains($selectedUserId)) {
            $selectedUserId = null;
        }

        return view('admin.cotisations.create', compact('users', 'associations', 'selectedUserId'));
    }


    public function store(Request $request)
    {
        $this->authorize('create cotisation');
        $authUser = auth()->user();

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'association_id' => 'required|exists:associations,id',
            'year' => 'required|integer|min:1900|max:' . (now()->year + 1),
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
            'paid_at' => 'nullable|date',
            'receipt_number' => 'nullable|string|unique:cotisations,receipt_number',
            'approved_by' => 'nullable|exists:users,id',
        ]);

        // Extra security for admins
        if ($authUser->hasRole('admin')) {
            $user = User::find($validated['user_id']);
            if ($user->association_id != $authUser->association_id || $validated['association_id'] != $authUser->association_id) {
                abort(403, 'You can only create cotisations for your association.');
            }
        }

        // Prevent duplicate for same year
        $exists = Cotisation::where('user_id', $validated['user_id'])
            ->where('year', $validated['year'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'year' => 'This user already has a cotisation for the year ' . $validated['year'] . '.'
            ])->withInput();
        }

        Cotisation::create($validated);

        return redirect()->route('admin.cotisations.index')->with('toast', 'Cotisation created successfully.');
    }

    public function edit(Cotisation $cotisation)
    {
        $this->authorize('edit cotisation');
        $authUser = auth()->user();

        if ($authUser->hasRole('super_admin')) {
            $users = User::all();
            $associations = Association::all();
        } elseif ($authUser->hasRole('admin')) {
            if ($cotisation->association_id != $authUser->association_id) {
                abort(403, 'You cannot edit cotisations outside your association.');
            }
            $users = User::where('association_id', $authUser->association_id)->get();
            $associations = Association::where('id', $authUser->association_id)->get();
        } else {
            abort(403);
        }

        return view('admin.cotisations.edit', compact('cotisation', 'users', 'associations'));
    }

    public function update(Request $request, Cotisation $cotisation)
    {
        $this->authorize('edit cotisation');
        $authUser = auth()->user();

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'association_id' => 'required|exists:associations,id',
            'year' => 'required|integer|min:1900|max:' . (now()->year + 1),
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
            'paid_at' => 'nullable|date',
            'receipt_number' => 'nullable|string|unique:cotisations,receipt_number,' . $cotisation->id,
            'approved_by' => 'nullable|exists:users,id',
        ]);

        if ($authUser->hasRole('admin')) {
            $user = User::find($validated['user_id']);
            if ($user->association_id != $authUser->association_id || $validated['association_id'] != $authUser->association_id) {
                abort(403, 'You can only update cotisations for your association.');
            }
        }

        $cotisation->update($validated);

        return redirect()->route('admin.cotisations.index')->with('toast', 'Cotisation updated successfully.');
    }

    public function destroy(Cotisation $cotisation)
    {
        $this->authorize('delete cotisation');
        $authUser = auth()->user();

        if ($authUser->hasRole('admin') && $cotisation->association_id != $authUser->association_id) {
            abort(403, 'You cannot delete cotisations outside your association.');
        }

        $cotisation->delete();

        return redirect()->route('admin.cotisations.index')->with('toast', 'Cotisation deleted.');
    }
}
