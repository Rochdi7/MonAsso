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
        $auth = Auth::user();

        $events = Event::with('association')
            ->when(!$auth->hasRole('super_admin'), function ($query) use ($auth) {
                $query->where('association_id', $auth->association_id);
            })
            ->latest()
            ->get();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $auth = Auth::user();
        $associations = $auth->hasRole('super_admin')
            ? Association::all()
            : Association::where('id', $auth->association_id)->get();

        return view('admin.events.create', compact('associations'));
    }

    public function store(Request $request)
    {
        $auth = Auth::user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'association_id' => 'required|exists:associations,id',
            'status' => 'required|in:0,1,2',
        ]);

        // Force association_id if not super_admin
        if (!$auth->hasRole('super_admin')) {
            $validated['association_id'] = $auth->association_id;
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        $auth = Auth::user();

        if (!$auth->hasRole('super_admin') && $event->association_id !== $auth->association_id) {
            abort(403);
        }

        $associations = $auth->hasRole('super_admin')
            ? Association::all()
            : Association::where('id', $auth->association_id)->get();

        return view('admin.events.edit', compact('event', 'associations'));
    }

    public function update(Request $request, Event $event)
    {
        $auth = Auth::user();

        if (!$auth->hasRole('super_admin') && $event->association_id !== $auth->association_id) {
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

        if (!$auth->hasRole('super_admin')) {
            $validated['association_id'] = $auth->association_id;
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $auth = Auth::user();

        if ($auth->hasRole('board')) {
            abort(403, 'Board members are not allowed to delete events.');
        }

        if (!$auth->hasRole('super_admin') && $event->association_id !== $auth->association_id) {
            abort(403);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }


}
