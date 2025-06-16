@extends('layouts.main')

@section('title', 'View Membre')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'View Membre')

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

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Membre Details</h5>
                <a href="{{ route('admin.membres.index') }}" class="btn btn-sm btn-secondary">Back</a>
            </div>

            <div class="card-body">

                {{-- Photo --}}
                <div class="mb-4 text-center">
                    @if($user->getFirstMediaUrl('profile_photo'))
                        <img src="{{ $user->getFirstMediaUrl('profile_photo') }}" class="rounded-circle shadow" width="120" height="120" alt="Profile Photo">
                    @else
                        <span class="text-muted">No photo available</span>
                    @endif
                </div>

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Full Name:</label>
                    <div>{{ $user->name }}</div>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Email:</label>
                    <div>{{ $user->email }}</div>
                </div>

                {{-- Phone --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Phone:</label>
                    <div>{{ $user->phone ?? 'N/A' }}</div>
                </div>

                {{-- Role --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Role:</label>
                    <div>
                        <span class="badge bg-secondary text-uppercase">
                            {{ $user->getRoleNames()->first() ?? 'N/A' }}
                        </span>
                    </div>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Status:</label>
                    <div>
                        @if($user->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </div>
                </div>

                {{-- Association --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Association:</label>
                    <div>{{ $user->association?->name ?? 'N/A' }}</div>
                </div>

                {{-- Created At (Safe version) --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Created At:</label>
                    <div>{{ optional($user->created_at)->format('Y-m-d H:i') ?? 'N/A' }}</div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
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
