@extends('layouts.main')

@section('title', 'Meetings Management')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Manage Meetings')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/style.css') }}">
@endsection

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
                <h5 class="mb-3 mb-sm-0">Meetings List</h5>
                @if (auth()->user()->hasAnyRole(['admin', 'superadmin', 'board', 'supervisor']))
                    <a href="{{ route('admin.meetings.create') }}" class="btn btn-primary">Add Meeting</a>
                @endif
            </div>
            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Organizer</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Documents</th>
                                @if (auth()->user()->hasAnyRole(['admin', 'superadmin', 'board', 'supervisor', 'member']))
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($meetings as $meeting)
                                <tr>
                                    <td>{{ $meeting->title }}</td>
                                    <td>{{ $meeting->organizer->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($meeting->datetime)->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @if($meeting->status === 1)
                                            <span class="badge bg-light-success text-success">✔ Confirmed</span>
                                        @elseif($meeting->status === 2)
                                            <span class="badge bg-light-danger text-danger">✖ Cancelled</span>
                                        @else
                                            <span class="badge bg-light-warning text-warning">⏳ Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($meeting->getMedia('documents')->isNotEmpty())
                                            <span class="text-success">There are documents</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (auth()->user()->hasAnyRole(['admin', 'superadmin', 'board', 'supervisor', 'member']))
                                            <a href="{{ route('admin.meetings.show', $meeting) }}"
                                               class="avtar avtar-xs btn-link-secondary me-2" title="View">
                                                <i class="ti ti-eye f-20"></i>
                                            </a>
                                        @endif

                                        @if (auth()->user()->hasAnyRole(['admin', 'superadmin', 'board', 'supervisor']))
                                            <a href="{{ route('admin.meetings.edit', $meeting) }}"
                                               class="avtar avtar-xs btn-link-secondary me-2" title="Edit">
                                                <i class="ti ti-edit f-20"></i>
                                            </a>
                                        @endif

                                        @if (auth()->user()->hasAnyRole(['admin', 'superadmin', 'supervisor']))
                                            <form action="{{ route('admin.meetings.destroy', $meeting) }}" method="POST"
                                                  class="d-inline-block"
                                                  onsubmit="return confirm('Are you sure you want to delete this meeting?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                                        title="Delete">
                                                    <i class="ti ti-trash f-20"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No meetings found.</td>
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
