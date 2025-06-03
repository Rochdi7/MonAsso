@extends('layouts.main')

@section('title', 'Add Role')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Add Role')
@section('page-animation', 'animate__rollIn')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/animate.min.css') }}">
@endsection

@section('content')

@if ($errors->any())
<div class="alert alert-danger animate__animated animate__shakeX">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
    <div class="col-12">
        <div id="role-create-card" class="card shadow-sm animate__animated animate__rollIn">
            <div class="card-header">
                <h5 class="mb-0">Add New Role</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.roles.store') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">

                        <!-- Role Name -->
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Role Name</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Enter role name" required>
                                <div class="invalid-feedback">
                                    @error('name') {{ $message }} @else Please enter a role name. @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Permissions -->
                        <div class="col-md-12">
                            <label class="form-label">Assign Permissions</label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permission->name }}"
                                               class="form-check-input"
                                               id="perm_{{ $permission->id }}"
                                               @checked(is_array(old('permissions')) && in_array($permission->name, old('permissions')))>
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-12 text-end mt-4">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary"
                               onclick="rollOutCard(event, this, 'role-create-card')">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Role</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
    // Bootstrap validation
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            const forms = document.getElementsByClassName('needs-validation');
            Array.prototype.forEach.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // Cancel animation
    function rollOutCard(event, link, cardId = 'role-create-card') {
        event.preventDefault();
        const card = document.getElementById(cardId);
        if (!card) return;

        card.classList.remove('animate__rollIn', 'animate__zoomIn', 'animate__fadeInUp');
        card.classList.add('animate__animated', 'animate__rollOut');

        setTimeout(() => {
            window.location.href = link.href;
        }, 1000);
    }

    // Toast auto-show
    document.addEventListener("DOMContentLoaded", function () {
        let toastEl = document.querySelector('.toast');
        if (toastEl) {
            let toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    });
</script>
@endsection
