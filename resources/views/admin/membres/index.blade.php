@extends('layouts.main')

@section('title', 'Membres Management')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Manage Membres')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('build/css/plugins/style.css') }}">
@endsection

@section('content')

@if(session()->has('toast') || session()->has('success') || session()->has('error'))
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
                <h5 class="mb-3 mb-sm-0">Membres List</h5>
                <a href="{{ route('admin.membres.create') }}" class="btn btn-primary">Add Membre</a>
            </div>

            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Association</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>
                                    @if($user->getFirstMediaUrl('profile_photo'))
                                        <img src="{{ $user->getFirstMediaUrl('profile_photo') }}" alt="photo" width="40" height="40" class="rounded-circle shadow-sm">
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone ?? '-' }}</td>
                                <td><span class="badge bg-secondary text-uppercase">{{ $user->getRoleNames()->first() ?? 'N/A' }}</span></td>
                                <td>{!! $user->is_active ? '<span class="text-success">✔ Active</span>' : '<span class="text-danger">✘ Inactive</span>' !!}</td>
                                <td>{{ $user->association?->name ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.membres.show', $user->id) }}" class="avtar avtar-xs btn-link-secondary" title="View">
                                        <i class="ti ti-eye f-20"></i>
                                    </a>
                                    <a href="{{ route('admin.membres.edit', $user->id) }}" class="avtar avtar-xs btn-link-secondary" title="Edit">
                                        <i class="ti ti-edit f-20"></i>
                                    </a>
                                    <form action="{{ route('admin.membres.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user?')" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0" title="Delete">
                                            <i class="ti ti-trash f-20"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No users found.</td>
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
