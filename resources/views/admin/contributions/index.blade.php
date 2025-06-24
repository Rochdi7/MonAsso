@extends('layouts.main')

@section('title', 'Contributions Management')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Manage Contributions')

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
                <h5 class="mb-3 mb-sm-0">Contributions List</h5>
                {{-- Show Add button based on role --}}
                @hasanyrole('admin|superadmin|board')
                <a href="{{ route('admin.contributions.create') }}" class="btn btn-primary">Add Contribution</a>
                @endhasanyrole
            </div>
            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Association</th>
                                <th>Received At</th>
                                <th>Description</th>
                                {{-- Show Actions column header if Admin, Superadmin, or Board --}}
                                @hasanyrole('admin|superadmin|board')
                                <th>Actions</th>
                                @endhasanyrole
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contributions as $contribution)
                            <tr>
                                <td>
                                    @if($contribution->type == 1)
                                        <span class="badge bg-light-primary text-primary">Subvention</span>
                                    @elseif($contribution->type == 2)
                                        <span class="badge bg-light-info text-info">Don</span>
                                    @else
                                        <span class="badge bg-light-secondary text-muted">Unknown</span>
                                    @endif
                                </td>
                                <td>{{ number_format($contribution->amount, 2) }} MAD</td>
                                <td>{{ $contribution->association->name ?? '—' }}</td>
                                <td>{{ optional($contribution->received_at)->format('Y-m-d') ?? '—' }}</td>
                                <td>{{ $contribution->description ?? '—' }}</td>
                                {{-- Show Actions column data if Admin, Superadmin, or Board --}}
                                @hasanyrole('admin|superadmin|board')
                                <td>
                                    {{-- Show Edit button if Admin, Superadmin, or Board AND it's their association's contribution --}}
                                    @if (auth()->user()->hasAnyRole(['admin', 'board', 'superadmin']) && (auth()->user()->hasRole('superadmin') || auth()->user()->association_id === $contribution->association_id))
                                    <a href="{{ route('admin.contributions.edit', $contribution) }}"
                                        class="avtar avtar-xs btn-link-secondary me-2" title="Edit">
                                        <i class="ti ti-edit f-20"></i>
                                    </a>
                                    @endif

                                    {{-- Show Delete button if Admin or Superadmin AND it's their association's contribution --}}
                                    @if (auth()->user()->hasAnyRole(['admin', 'superadmin']) && (auth()->user()->hasRole('superadmin') || auth()->user()->association_id === $contribution->association_id))
                                    <form action="{{ route('admin.contributions.destroy', $contribution) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                            onclick="return confirm('Delete this contribution?')" title="Delete">
                                            <i class="ti ti-trash f-20"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                                @endhasanyrole
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No contributions found.</td>
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
    import { DataTable }s from "/build/js/plugins/module.js";
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
