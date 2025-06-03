@extends('layouts.main')

@section('title', 'Associations Management')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Manage Associations')

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
                        <h5 class="mb-3 mb-sm-0">Associations List</h5>
                        <div>
                            <a href="{{ route('admin.associations.create') }}" class="btn btn-primary">Add Association</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Validated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($associations as $association)
                                    <tr>
                                        <td>
                                            @if($association->getFirstMediaUrl('logos'))
                                                <img src="{{ $association->getFirstMediaUrl('logos') }}" alt="logo" width="40"
                                                    height="40" class="rounded shadow-sm">
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $association->name }}</td>
                                        <td>{{ $association->email }}</td>
                                        <td>
                                            @php
                                                $status = $association->announcement_status;
                                            @endphp
                                            @if($status === 'active')
                                                <span class="badge bg-light-success text-success">✔ Active</span>
                                            @elseif($status === 'pending')
                                                <span class="badge bg-light-warning text-warning">⏳ Pending</span>
                                            @elseif($status === 'suspended')
                                                <span class="badge bg-light-danger text-danger">⛔ Suspended</span>
                                            @else
                                                <span class="badge bg-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $association->creation_date ?? 'N/A' }}</td>
                                        <td>
                                            @if($association->is_validated)
                                                <span class="badge bg-light-success text-success"
                                                    title="Validated on {{ $association->validation_date }}">
                                                    {{ $association->validation_date }}
                                                </span>
                                            @else
                                                <span class="badge bg-light-danger text-danger" title="Not Validated">
                                                    Not Validated
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.associations.edit', $association) }}"
                                                class="avtar avtar-xs btn-link-secondary me-2" title="Edit">
                                                <i class="ti ti-edit f-20"></i>
                                            </a>
                                            <form action="{{ route('admin.associations.destroy', $association) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf @method('DELETE')
                                                <button class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                                    onclick="return confirm('Delete this association?')" title="Delete">
                                                    <i class="ti ti-trash f-20"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No associations found.</td>
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