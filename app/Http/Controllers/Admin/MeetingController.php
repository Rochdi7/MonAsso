<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetingDocument;
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
        abort_if(!auth()->user()->hasAnyRole(['admin', 'super_admin']), 403);

        $associations = Association::all();
        $users = User::all();
        return view('admin.meetings.create', compact('associations', 'users'));
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()->hasAnyRole(['admin', 'super_admin']), 403);

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
        abort_if(!auth()->user()->hasAnyRole(['admin', 'super_admin']), 403);

        $associations = Association::all();
        $users = User::all();
        $documents = $meeting->getMedia('documents');

        return view('admin.meetings.edit', compact('meeting', 'associations', 'users', 'documents'));
    }




    public function update(Request $request, Meeting $meeting)
    {
        abort_if(!auth()->user()->hasAnyRole(['admin', 'super_admin']), 403);

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

        // Only clear and re-upload documents if new ones were submitted
        if ($request->hasFile('documents')) {
            // Optional: only remove documents that are not in keep list
            $meeting->clearMediaCollection('documents');

            foreach ($request->file('documents') as $file) {
                $meeting->addMedia($file)->toMediaCollection('documents');
            }
        }

        return redirect()->route('admin.meetings.index')->with('success', 'Meeting updated successfully.');
    }

    public function destroy(Meeting $meeting)
    {
        abort_if(!auth()->user()->hasAnyRole(['admin', 'super_admin']), 403);

        $meeting->clearMediaCollection('documents');
        $meeting->delete();
        return redirect()->route('admin.meetings.index')->with('success', 'Meeting deleted.');
    }

    public function show(Meeting $meeting)
    {
        abort_if(!auth()->user()->hasAnyRole(['admin', 'super_admin']), 403);

        $documents = $meeting->getMedia('documents');
        return view('admin.meetings.show', compact('meeting', 'documents'));
    }


    public function removeMedia(Meeting $meeting, $mediaId)
    {
        $media = $meeting->media()->where('id', $mediaId)->firstOrFail();
        $media->delete();

        return back()->with('success', 'Document removed successfully.');
    }



}
