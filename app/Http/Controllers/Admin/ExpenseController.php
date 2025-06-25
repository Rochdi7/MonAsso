<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('superadmin')) {
            $expenses = Expense::with('association')->latest()->get();
        } else {
            $expenses = Expense::with('association')
                ->where('association_id', $user->association_id)
                ->latest()
                ->get();
        }
        return view('admin.expenses.index', compact('expenses'));
    }

    public function create()
    {
        $user = Auth::user()->load('association');
        if (!$user->hasAnyRole(['admin', 'superadmin', 'board'])) {
            abort(403);
        }

        $associations = $user->hasRole('superadmin')
            ? Association::pluck('name', 'id')
            : collect();

        return view('admin.expenses.create', [
            'associations' => $associations,
            'authUser' => $user,
        ]);
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasAnyRole(['admin', 'superadmin', 'board'])) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'spent_at' => 'nullable|date',
            'association_id' => 'required|exists:associations,id',
        ]);

        // Explicitly cast to integer for comparison to avoid type mismatches
        if (!$user->hasRole('superadmin') && (int) $validated['association_id'] !== (int) $user->association_id) {
            abort(403, 'You can only create expenses for your own association.');
        }

        Expense::create($validated);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense recorded successfully.');
    }

    public function show(Expense $expense)
    {
        $user = Auth::user();
        if (!$user->hasRole('superadmin') && $expense->association_id !== $user->association_id) {
            abort(403);
        }
        return view('admin.expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $user = Auth::user()->load('association');
        if (!$user->hasAnyRole(['admin', 'superadmin', 'board'])) {
            abort(403);
        }
        if (!$user->hasRole('superadmin') && $expense->association_id !== $user->association_id) {
            abort(403);
        }

        $associations = $user->hasRole('superadmin')
            ? Association::pluck('name', 'id')
            : collect(); 

        return view('admin.expenses.edit', [
            'expense' => $expense,
            'associations' => $associations,
            'authUser' => $user,
        ]);
    }


    public function update(Request $request, Expense $expense)
    {
        $user = Auth::user();
        if (!$user->hasAnyRole(['admin', 'superadmin', 'board'])) {
            abort(403);
        }
        if (!$user->hasRole('superadmin') && $expense->association_id !== $user->association_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'spent_at' => 'nullable|date',
            'association_id' => 'required|exists:associations,id',
        ]);

        // Ensure association_id cannot be changed to another association by non-superadmins
        if (!$user->hasRole('superadmin') && (int) $validated['association_id'] !== (int) $expense->association_id) {
            abort(403);
        }

        $expense->update($validated);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $user = Auth::user();
        if (!$user->hasAnyRole(['admin', 'superadmin'])) {
            abort(403);
        }
        if (!$user->hasRole('superadmin') && $expense->association_id !== $user->association_id) {
            abort(403);
        }
        $expense->delete();
        return redirect()->route('admin.expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
