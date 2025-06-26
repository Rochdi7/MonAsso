@extends('layouts.main')

@section('title', 'Cotisations Management')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Manage Cotisations')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/style.css') }}">
@endsection

@php
    $user = auth()->user();
    $isMember = $user->hasRole('member');
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
                    <h5 class="mb-3 mb-sm-0">{{ $isMember ? 'My Cotisations' : 'Cotisations List' }}</h5>
                    @if (!$isMember && $user->hasAnyRole(['admin', 'superadmin', 'board']))
                        <a href="{{ route('admin.cotisations.create') }}" class="btn btn-primary">Add Cotisation</a>
                    @endif
                </div>
                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    @unless($isMember)<th>User</th>@endunless
                                    <th>Year</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Paid At</th>
                                    <th>Receipt</th>
                                    @unless($isMember)
                                        @if ($user->hasAnyRole(['admin', 'superadmin', 'board']))
                                        <th>Actions</th>
                                        @endif
                                    @endunless
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cotisations as $cotisation)
                                    <tr>
                                        @unless($isMember)<td>{{ $cotisation->user->name ?? '—' }}</td>@endunless
                                        <td>{{ $cotisation->year }}</td>
                                        <td>{{ number_format($cotisation->amount, 2) }} MAD</td>
                                        <td class="text-center fs-5">
                                            @if($cotisation->status == 1)
                                                <span class="text-success">✔</span>
                                            @elseif($cotisation->status == 0)
                                                <span class="text-warning">●</span>
                                            @elseif($cotisation->status == 2)
                                                <span class="text-danger">⚠</span>
                                            @elseif($cotisation->status == 3)
                                                <span class="text-secondary">✖</span>
                                            @else
                                                <span class="text-muted">?</span>
                                            @endif
                                        </td>
                                        <td>{{ optional($cotisation->paid_at)->format('Y-m-d H:i') ?? '—' }}</td>
                                        <td>{{ $cotisation->receipt_number ?? '—' }}</td>
                                        @unless($isMember)
                                            @if ($user->hasAnyRole(['admin', 'superadmin', 'board']))
                                                <td>
                                                    @if ($user->hasAnyRole(['admin', 'superadmin', 'board']) && ($user->hasRole('superadmin') || (int)$cotisation->association_id === (int)$user->association_id))
                                                    <a href="{{ route('admin.cotisations.edit', $cotisation) }}"
                                                        class="avtar avtar-xs btn-link-secondary me-2" title="Edit">
                                                        <i class="ti ti-edit f-20"></i>
                                                    </a>
                                                    @endif
                                                    @if ($user->hasAnyRole(['admin', 'superadmin']) && ($user->hasRole('superadmin') || (int)$cotisation->association_id === (int)$user->association_id))
                                                    <form action="{{ route('admin.cotisations.destroy', $cotisation) }}" method="POST"
                                                        style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                                            onclick="return confirm('Delete this cotisation?')" title="Delete">
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
                                        <td colspan="{{ $isMember ? 6 : 7 }}" class="text-center text-muted">No cotisations found.</td>
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
