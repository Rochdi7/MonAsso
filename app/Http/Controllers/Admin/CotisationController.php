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

        if ($user->hasRole('superadmin')) {
            $cotisations = Cotisation::with(['user', 'association'])->latest()->get();
        } elseif ($user->hasAnyRole(['admin', 'board'])) {
            $cotisations = Cotisation::with(['user', 'association'])
                ->where('association_id', $user->association_id)
                ->latest()->get();
        } elseif ($user->hasRole('member')) {
            $cotisations = Cotisation::with('association')
                ->where('user_id', $user->id)
                ->latest()->get();
        } else {
            abort(403, 'Unauthorized access to cotisations list.');
        }

        return view('admin.cotisations.index', compact('cotisations'));
    }

    public function create(Request $request)
    {
        $authUser = auth()->user();

        if (!$authUser->hasAnyRole(['admin', 'superadmin', 'board'])) {
            abort(403, 'Unauthorized to create cotisations.');
        }

        $selectedUserId = $request->get('user_id');

        if ($authUser->hasRole('superadmin')) {
            $users = User::all();
            $associations = Association::all();
        } else {
            $users = User::where('association_id', $authUser->association_id)->get();
            $associations = Association::where('id', $authUser->association_id)->get();
        }

        if ($selectedUserId && !$users->pluck('id')->contains((int)$selectedUserId)) { // Type cast for pluck
            $selectedUserId = null;
        }

        return view('admin.cotisations.create', compact('users', 'associations', 'selectedUserId'));
    }

    public function store(Request $request)
    {
        $authUser = auth()->user();

        if (!$authUser->hasAnyRole(['admin', 'superadmin', 'board'])) {
            abort(403, 'Unauthorized to store cotisations.');
        }

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

        if (!$authUser->hasRole('superadmin')) {
            $userForCotisation = User::find($validated['user_id']); // Renamed variable for clarity
            if (!$userForCotisation || (int)$userForCotisation->association_id !== (int)$authUser->association_id || (int)$validated['association_id'] !== (int)$authUser->association_id) {
                abort(403, 'You can only create cotisations for users within your association and for your association.');
            }
        }

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
        $authUser = auth()->user();

        if (!$authUser->hasAnyRole(['admin', 'superadmin', 'board'])) {
            abort(403, 'Unauthorized to edit cotisations.');
        }

        if (!$authUser->hasRole('superadmin') && (int)$cotisation->association_id !== (int)$authUser->association_id) {
            abort(403, 'You cannot edit cotisations outside your association.');
        }

        $users = $authUser->hasRole('superadmin')
            ? User::all()
            : User::where('association_id', $authUser->association_id)->get();

        $associations = $authUser->hasRole('superadmin')
            ? Association::all()
            : Association::where('id', $authUser->association_id)->get();

        return view('admin.cotisations.edit', compact('cotisation', 'users', 'associations'));
    }

    public function update(Request $request, Cotisation $cotisation)
    {
        $authUser = auth()->user();

        if (!$authUser->hasAnyRole(['admin', 'superadmin', 'board'])) {
            abort(403, 'Unauthorized to update cotisations.');
        }

        if (!$authUser->hasRole('superadmin') && (int)$cotisation->association_id !== (int)$authUser->association_id) {
            abort(403, 'You cannot update cotisations outside your association.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'association_id' => 'required|exists:associations,id',
            'year' => 'required|integer|min:1900|max:' . (now()->year + 1),
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:0,1,2,3', // Allow all 4 statuses for update
            'paid_at' => 'nullable|date',
            'receipt_number' => 'nullable|string|unique:cotisations,receipt_number,' . $cotisation->id,
            'approved_by' => 'nullable|exists:users,id',
        ]);

        if (!$authUser->hasRole('superadmin')) {
            $userForCotisation = User::find($validated['user_id']); // Renamed variable
            // Ensure the user associated with the cotisation and the association_id in payload belong to current user's association
            if (!$userForCotisation || (int)$userForCotisation->association_id !== (int)$authUser->association_id || (int)$validated['association_id'] !== (int)$authUser->association_id) {
                abort(403, 'You can only update cotisations for users within your association and for your association.');
            }
            // Prevent changing association_id of an existing cotisation by non-superadmins
            if ((int)$validated['association_id'] !== (int)$cotisation->association_id) {
                abort(403, 'You cannot reassign a cotisation to another association.');
            }
        }

        $cotisation->update($validated);

        return redirect()->route('admin.cotisations.index')->with('toast', 'Cotisation updated successfully.');
    }

    public function destroy(Cotisation $cotisation)
    {
        $authUser = auth()->user();

        if ($authUser->hasRole('board')) {
            abort(403, 'Board members are not allowed to delete cotisations.');
        }

        if (!$authUser->hasAnyRole(['admin', 'superadmin'])) {
            abort(403, 'Unauthorized to delete cotisations.');
        }

        if (!$authUser->hasRole('superadmin') && (int)$cotisation->association_id !== (int)$authUser->association_id) {
            abort(403, 'You cannot delete cotisations outside your association.');
        }

        $cotisation->delete();

        return redirect()->route('admin.cotisations.index')->with('toast', 'Cotisation deleted.');
    }
}
