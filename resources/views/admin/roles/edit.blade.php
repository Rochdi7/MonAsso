@extends('layouts.main')

@section('title', 'Edit Role')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Edit Role')
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
    <div class="col-sm-12">
        <div id="role-edit-card" class="card animate__animated animate__rollIn">
            <div class="card-header">
                <h5 class="mb-0">Edit Role</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.roles.update', $role->id) }}" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6 col-xl-4">
                            <label class="form-label">Role Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Enter role name" value="{{ old('name', $role->name) }}" required>
                            <div class="invalid-feedback">
                                @error('name') {{ $message }} @else Please enter the role name. @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <h5 class="mt-4">Assign Permissions</h5>
                            <div class="row">
                                @foreach($permissions as $permission)
                                <div class="col-sm-6 col-md-4 col-lg-3">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permission->name }}"
                                               id="perm_{{ $permission->id }}"
                                               @checked(in_array($permission->name, old('permissions', $role->permissions->pluck('name')->toArray())))>
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12 text-end mt-4">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary"
                               onclick="rollOutCard(event, this, 'role-edit-card')">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Role</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Bootstrap form validation
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

    // RollOut animation for cancel
    function rollOutCard(event, link, cardId = 'role-edit-card') {
        event.preventDefault();
        const card = document.getElementById(cardId);
        if (!card) return;

        card.classList.remove('animate__rollIn');
        card.classList.add('animate__animated', 'animate__rollOut');

        setTimeout(() => {
            window.location.href = link.href;
        }, 1000);
    }
</script>
@endsection
