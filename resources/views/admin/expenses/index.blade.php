@extends('layouts.main')

@section('title', 'Expenses Management')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Manage Expenses')

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
                <h5 class="mb-3 mb-sm-0">Expenses List</h5>
                @hasanyrole('admin|superadmin|board')
                <a href="{{ route('admin.expenses.create') }}" class="btn btn-primary">Add Expense</a>
                @endhasanyrole
            </div>
            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Spent At</th>
                                <th>Association</th>
                                <th>Description</th>
                                @hasanyrole('admin|superadmin|board')
                                <th>Actions</th>
                                @endhasanyrole
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $expense)
                            <tr>
                                <td>{{ $expense->title }}</td>
                                <td>{{ number_format($expense->amount, 2) }} MAD</td>
                                <td>{{ optional($expense->spent_at)->format('Y-m-d') ?? '—' }}</td>
                                <td>{{ $expense->association->name ?? '—' }}</td>
                                <td>{{ $expense->description ?? '—' }}</td>
                                @hasanyrole('admin|superadmin|board')
                                <td>
                                    @if (auth()->user()->hasAnyRole(['admin', 'superadmin', 'board']) && (auth()->user()->hasRole('superadmin') || auth()->user()->association_id === $expense->association_id))
                                    <a href="{{ route('admin.expenses.edit', $expense) }}"
                                        class="avtar avtar-xs btn-link-secondary me-2" title="Edit">
                                        <i class="ti ti-edit f-20"></i>
                                    </a>
                                    @endif

                                    @if (auth()->user()->hasAnyRole(['admin', 'superadmin']) && (auth()->user()->hasRole('superadmin') || auth()->user()->association_id === $expense->association_id))
                                    <form action="{{ route('admin.expenses.destroy', $expense) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                            onclick="return confirm('Delete this expense?')" title="Delete">
                                            <i class="ti ti-trash f-20"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                                @endhasanyrole
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No expenses found.</td>
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
