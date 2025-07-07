<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Association;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $meetings = Meeting::with(['association', 'organizer'])
            ->when(!$user->hasRole('superadmin'), function ($query) use ($user) {
                $query->where('association_id', $user->association_id);
            })
            ->latest()
            ->get();

        return view('admin.meetings.index', compact('meetings'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->hasAnyRole(['admin', 'superadmin', 'board', 'supervisor'])) {
            abort(403, 'Unauthorized to create meetings.');
        }

        $associations = $user->hasRole('superadmin')
            ? Association::all()
            : Association::where('id', $user->association_id)->get();

        $users = $user->hasRole('superadmin')
            ? User::all()
            : User::where('association_id', $user->association_id)->get();

        return view('admin.meetings.create', [
            'auth' => $user,
            'associations' => $associations,
            'users' => $users,
        ]);
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasAnyRole(['admin', 'superadmin', 'board', 'supervisor'])) {
            abort(403, 'Unauthorized to store meetings.');
        }

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

        if (!$user->hasRole('superadmin')) {
            if ((int) $validated['association_id'] !== (int) $user->association_id) {
                abort(403, 'You can only create meetings for your own association.');
            }
            $validated['association_id'] = $user->association_id;
            $organizer = User::find($validated['organizer_id']);
            if (!$organizer || (int) $organizer->association_id !== (int) $user->association_id) {
                abort(403, 'Organizer must belong to your association.');
            }
        }

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
        $user = Auth::user();
        if (!$user->hasAnyRole(['admin', 'superadmin', 'board', 'supervisor'])) {
            abort(403, 'Unauthorized to edit meetings.');
        }

        if (!$user->hasRole('superadmin') && (int) $meeting->association_id !== (int) $user->association_id) {
            abort(403);
        }

        $associations = $user->hasRole('superadmin')
            ? Association::all()
            : Association::where('id', $user->association_id)->get();

        $users = $user->hasRole('superadmin')
            ? User::all()
            : User::where('association_id', $user->association_id)->get();

        $documents = $meeting->getMedia('documents');

        return view('admin.meetings.edit', [
            'meeting' => $meeting,
            'associations' => $associations,
            'users' => $users,
            'documents' => $documents,
            'auth' => $user,
        ]);
    }


    public function update(Request $request, Meeting $meeting)
    {
        $user = Auth::user();
        if (!$user->hasAnyRole(['admin', 'superadmin', 'board', 'supervisor'])) {
            abort(403, 'Unauthorized to update meetings.');
        }

        if (!$user->hasRole('superadmin') && (int) $meeting->association_id !== (int) $user->association_id) {
            abort(403);
        }

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

        if (!$user->hasRole('superadmin')) {
            if ((int) $validated['association_id'] !== (int) $meeting->association_id) {
                abort(403, 'You cannot change the association of this meeting.');
            }
            $organizer = User::find($validated['organizer_id']);
            if (!$organizer || (int) $organizer->association_id !== (int) $user->association_id) {
                abort(403, 'Organizer must belong to your association.');
            }
            $validated['association_id'] = $meeting->association_id;
        }

        $meeting->update($validated);

        // Document handling: only add new files if present, do not clear existing if none are uploaded
        if ($request->hasFile('documents')) {
            // This loop only adds new documents. It does NOT clear existing documents.
            foreach ($request->file('documents') as $file) {
                $meeting->addMedia($file)->toMediaCollection('documents');
            }
        }

        return redirect()->route('admin.meetings.index')->with('success', 'Meeting updated successfully.');
    }

    public function destroy(Meeting $meeting)
    {
        $user = Auth::user();

        // 🔍 Log debug info to trace unexpected deletion triggers
        \Log::warning('Meeting deletion triggered', [
            'user_id' => $user->id,
            'user_roles' => $user->getRoleNames(),
            'request_method' => request()->method(),
            'request_url' => request()->fullUrl(),
            'referer' => request()->headers->get('referer'),
            'request_input' => request()->all(),
            'meeting_id' => $meeting->id,
        ]);

        // Block board and member users from deleting
        if ($user->hasAnyRole(['board', 'member'])) {
            abort(403, 'Board members and Members are not allowed to delete meetings.');
        }

        // Only allow these roles to delete
        if (!$user->hasAnyRole(['admin', 'superadmin', 'supervisor'])) {
            abort(403, 'Unauthorized action.');
        }

        // Non-superadmin can only delete meetings belonging to their own association
        if (!$user->hasRole('superadmin') && (int) $meeting->association_id !== (int) $user->association_id) {
            abort(403);
        }

        $meeting->clearMediaCollection('documents');
        $meeting->delete();

        return redirect()->route('admin.meetings.index')
            ->with('success', 'Meeting deleted.');
    }



    public function show(Meeting $meeting)
    {
        $user = Auth::user();
        if (!$user->hasAnyRole(['admin', 'superadmin', 'board', 'supervisor', 'member'])) {
            abort(403, 'Unauthorized to view meeting details.');
        }
        if (!$user->hasRole('superadmin') && (int) $meeting->association_id !== (int) $user->association_id) {
            abort(403);
        }

        $documents = $meeting->getMedia('documents');
        return view('admin.meetings.show', compact('meeting', 'documents'));
    }

    public function removeMedia(Meeting $meeting, $mediaId)
    {
        $user = Auth::user();
        // Board and Supervisor can remove media if they can update the meeting
        if (!$user->hasAnyRole(['admin', 'superadmin', 'board', 'supervisor'])) {
            abort(403, 'You are not authorized to remove meeting documents.');
        }

        if (!$user->hasRole('superadmin') && (int) $meeting->association_id !== (int) $user->association_id) {
            abort(403);
        }

        $media = $meeting->media()->where('id', $mediaId)->firstOrFail();
        $media->delete();

        return back()->with('success', 'Document removed successfully.');
    }
}
