<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Association;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::with(['association', 'organizer'])->latest()->get();
        return view('admin.meetings.index', compact('meetings'));
    }

    public function create()
    {
        $associations = Association::all();
        $users = User::all();
        return view('admin.meetings.create', compact('associations', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'datetime' => 'required|date',
            'status' => 'required|in:0,1,2',
            'location' => 'nullable|string',
            'association_id' => 'required|exists:associations,id',
            'organizer_id' => 'required|exists:users,id',
            'documents.*' => 'nullable|file|max:2048',
        ]);
        
        $meeting = Meeting::create($validated);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $meeting->addMedia($file)->toMediaCollection('documents');
            }
        }

        return redirect()->route('admin.meetings.index')->with('success', 'Meeting created successfully.');
    }

    public function edit(Meeting $meeting)
    {
        $associations = Association::all();
        $users = User::all();
        return view('admin.meetings.edit', compact('meeting', 'associations', 'users'));
    }

    public function update(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'datetime' => 'required|date',
            'status' => 'required|in:0,1,2',
            'location' => 'nullable|string',
            'association_id' => 'required|exists:associations,id',
            'organizer_id' => 'required|exists:users,id',
            'documents.*' => 'nullable|file|max:2048',
        ]);

        $meeting->update($validated);

        if ($request->hasFile('documents')) {
            $meeting->clearMediaCollection('documents');

            foreach ($request->file('documents') as $file) {
                $meeting->addMedia($file)->toMediaCollection('documents');
            }
        }

        return redirect()->route('admin.meetings.index')->with('success', 'Meeting updated successfully.');
    }

    public function destroy(Meeting $meeting)
    {
        $meeting->clearMediaCollection('documents');
        $meeting->delete();
        return redirect()->route('admin.meetings.index')->with('success', 'Meeting deleted.');
    }
}
