@extends('layouts.main')

@section('title', 'Add Role')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Add Role')

@section('css')
@endsection

@section('content')

<!-- SVG Icons for Alerts -->
<svg xmlns="http://www.w3.org/2000/svg" style="display: none">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 
            0 0 0-1.08.022L7.477 9.417 5.384 
            7.323a.75.75 0 0 0-1.06 1.06L6.97 
            11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 
            0 0 0-.01-1.05z" />
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 
            0 0 0-1.96 0L.165 13.233c-.457.778.091 
            1.767.98 1.767h13.713c.889 0 
            1.438-.99.98-1.767L8.982 
            1.566zM8 5c.535 0 .954.462.9.995l-.35 
            3.507a.552.552 0 0 1-1.1 0L7.1 
            5.995A.905.905 0 0 1 8 
            5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 
            1 0-2z" />
    </symbol>
</svg>

<!-- Alerts -->
@if(session('success'))
<div class="alert alert-success d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24">
        <use xlink:href="#check-circle-fill"></use>
    </svg>
    <div>{{ session('success') }}</div>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24">
        <use xlink:href="#exclamation-triangle-fill"></use>
    </svg>
    <div>{{ session('error') }}</div>
</div>
@endif

<!-- Main Content -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Add New Role</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.roles.store') }}">
                    @csrf
                    <div class="row">

                        <!-- Role Name -->
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Role Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter role name" required>
                            </div>
                        </div>

                        <!-- Permissions -->
                        <div class="col-md-12">
                            <label class="form-label">Assign Permissions</label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-check-input" id="perm_{{ $permission->id }}">
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-12 text-end mt-4">
                            <button type="submit" class="btn btn-primary">Create Role</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
@if(session('toast'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
    <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <img src="{{ asset('assets/images/favicon.svg') }}" class="rounded me-2" style="width: 17px;" alt="logo">
            <strong class="me-auto">Notification</strong>
            <small>Now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('toast') }}
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let toastEl = document.querySelector('.toast');
        if (toastEl) {
            let toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    });
</script>
@endsection
