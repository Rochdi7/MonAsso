@extends('layouts.main')

@section('title', 'Events Management')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Manage Events')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/style.css') }}">
@endsection

@php
    $user = auth()->user();
    $isMember = $user->hasRole('member'); // Corrected role name
@endphp

@section('content')
    @if(session('toast') || session('success') || session('error'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 99999">
            <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="{{ asset('favicon.svg') }}" class="img-fluid me-2" alt="favicon" style="width: 17px">
                    <strong class="me-auto">MonAsso</strong>
                    <small>Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('toast') ?? session('success') ?? session('error') }}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card table-card">
                <div class="card-header d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0">{{ $isMember ? 'My Events' : 'Events List' }}</h5>
                    @if (!$isMember && $user->hasAnyRole(['admin', 'superadmin', 'board']))
                        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">Add Event</a>
                    @endif
                </div>
                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Location</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Status</th>
                                    @unless($isMember)
                                        @if ($user->hasAnyRole(['admin', 'superadmin', 'board']))
                                            <th>Actions</th>
                                        @endif
                                    @endunless
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($events as $event)
                                    <tr>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ $event->location ?? '—' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($event->start_datetime)->format('Y-m-d H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($event->end_datetime)->format('Y-m-d H:i') }}</td>
                                        <td>
                                            @if($event->status === 1)
                                                <span class="badge bg-light-success text-success">Confirmed</span>
                                            @elseif($event->status === 2)
                                                <span class="badge bg-light-danger text-danger">Cancelled</span>
                                            @else
                                                <span class="badge bg-light-warning text-warning">Pending</span>
                                            @endif
                                        </td>
                                        @unless($isMember)
                                            @if ($user->hasAnyRole(['admin', 'superadmin', 'board']))
                                                <td>
                                                    @if ($user->hasAnyRole(['admin', 'superadmin', 'board']) && ($user->hasRole('superadmin') || (int)$event->association_id === (int)$user->association_id))
                                                    <a href="{{ route('admin.events.edit', $event) }}"
                                                        class="avtar avtar-xs btn-link-secondary me-2" title="Edit">
                                                        <i class="ti ti-edit f-20"></i>
                                                    </a>
                                                    @endif
                                                    @if ($user->hasAnyRole(['admin', 'superadmin']) && ($user->hasRole('superadmin') || (int)$event->association_id === (int)$user->association_id)) {{-- Board cannot delete, so removed 'board' from hasAnyRole --}}
                                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST"
                                                        style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                                            onclick="return confirm('Delete this event?')" title="Delete">
                                                            <i class="ti ti-trash f-20"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </td>
                                            @endif
                                        @endunless
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $isMember ? 5 : 6 }}" class="text-center text-muted">No events found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="module">
        import { DataTable } from "/build/js/plugins/module.js";
        window.dt = new DataTable("#pc-dt-simple");
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toastEl = document.getElementById('liveToast');
            if (toastEl) {
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            }
        });
    </script>
@endsection
