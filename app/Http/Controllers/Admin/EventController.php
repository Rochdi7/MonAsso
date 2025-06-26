<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Association;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();

        $events = Event::with('association')
            ->when(!$authUser->hasRole('superadmin'), function ($query) use ($authUser) {
                $query->where('association_id', $authUser->association_id);
            })
            ->latest()
            ->get();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $authUser = Auth::user();

        if (!$authUser->hasAnyRole(['admin', 'superadmin', 'board'])) {
            abort(403);
        }

        $associations = $authUser->hasRole('superadmin')
            ? Association::pluck('name', 'id')
            : Association::where('id', $authUser->association_id)->pluck('name', 'id');

        return view('admin.events.create', compact('authUser', 'associations'));
    }

    public function store(Request $request)
    {
        $authUser = Auth::user();

        if (!$authUser->hasAnyRole(['admin', 'superadmin', 'board'])) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'association_id' => 'required|exists:associations,id',
            'status' => 'required|in:0,1,2',
        ]);

        if (!$authUser->hasRole('superadmin')) {
            if ((int)$validated['association_id'] !== (int)$authUser->association_id) {
                abort(403);
            }
            $validated['association_id'] = $authUser->association_id;
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        $authUser = Auth::user();

        if (!$authUser->hasAnyRole(['admin', 'superadmin', 'board'])) {
            abort(403);
        }

        if (!$authUser->hasRole('superadmin') && (int)$event->association_id !== (int)$authUser->association_id) {
            abort(403);
        }

        $associations = $authUser->hasRole('superadmin')
            ? Association::pluck('name', 'id')
            : Association::where('id', $authUser->association_id)->pluck('name', 'id');

        return view('admin.events.edit', compact('authUser', 'event', 'associations'));
    }

    public function update(Request $request, Event $event)
    {
        $authUser = Auth::user();

        if (!$authUser->hasAnyRole(['admin', 'superadmin', 'board'])) {
            abort(403);
        }

        if (!$authUser->hasRole('superadmin') && (int)$event->association_id !== (int)$authUser->association_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'association_id' => 'required|exists:associations,id',
            'status' => 'required|in:0,1,2',
        ]);

        if (!$authUser->hasRole('superadmin')) {
            if ((int)$validated['association_id'] !== (int)$event->association_id) {
                abort(403);
            }
            $validated['association_id'] = $event->association_id;
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $authUser = Auth::user();

        if ($authUser->hasRole('board')) {
            abort(403);
        }

        if (!$authUser->hasAnyRole(['admin', 'superadmin'])) {
            abort(403);
        }

        if (!$authUser->hasRole('superadmin') && (int)$event->association_id !== (int)$authUser->association_id) {
            abort(403);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}
