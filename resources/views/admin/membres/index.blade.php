@extends('layouts.main')

@section('title', 'Membres Management')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Manage Membres')

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
            <div class="card-header">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0">Membres List</h5>
                    <div>
                        <a href="{{ route('admin.membres.create') }}" class="btn btn-primary">Add Membre</a>
                    </div>
                </div>
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
                            @forelse($membres as $membre)
                            <tr>
                                <td>
                                    @if($membre->getFirstMediaUrl('profile_photo'))
                                        <img src="{{ $membre->getFirstMediaUrl('profile_photo') }}" alt="photo" width="40" height="40" class="rounded-circle shadow-sm">
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $membre->name }}</td>
                                <td>{{ $membre->phone }}</td>
                                <td><span class="badge bg-secondary text-uppercase">{{ $membre->role }}</span></td>
                                <td>
                                    @if($membre->is_active)
                                        <span class="text-success">✔ Active</span>
                                    @else
                                        <span class="text-danger">✘ Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $membre->association?->name ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.membres.edit', $membre) }}"
                                        class="avtar avtar-xs btn-link-secondary me-2" title="Edit">
                                        <i class="ti ti-edit f-20"></i>
                                    </a>
                                    <form action="{{ route('admin.membres.destroy', $membre) }}" method="POST" style="display:inline-block;">
                                        @csrf @method('DELETE')
                                        <button class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                            onclick="return confirm('Delete this membre?')" title="Delete">
                                            <i class="ti ti-trash f-20"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No membres found.</td>
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
