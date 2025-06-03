@extends('layouts.main')

@section('title', 'Edit Permission')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Edit Permission')
@section('page-animation', 'animate__rollIn')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/animate.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        @if ($errors->any())
            <div class="alert alert-danger animate__animated animate__shakeX">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div id="permission-edit-card" class="card shadow-sm animate__animated animate__rollIn">
            <div class="card-body">
                <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Permission Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $permission->name) }}" required>
                            <div class="invalid-feedback">
                                @error('name') {{ $message }} @else Please enter the permission name. @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="guard_name" class="form-label">Guard Name</label>
                            <input type="text" class="form-control @error('guard_name') is-invalid @enderror"
                                   id="guard_name" name="guard_name" value="{{ old('guard_name', $permission->guard_name) }}" required>
                            <div class="invalid-feedback">
                                @error('guard_name') {{ $message }} @else Please enter the guard name. @enderror
                            </div>
                        </div>

                        <div class="col-12 text-end mt-4">
                            <a href="{{ route('admin.permissions.index') }}"
                               class="btn btn-outline-secondary"
                               onclick="rollOutCard(event, this, 'permission-edit-card')">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Permission</button>
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

    function rollOutCard(event, link, cardId = 'permission-edit-card') {
        event.preventDefault();
        const card = document.getElementById(cardId);
        if (!card) return;

        card.classList.remove('animate__rollIn', 'animate__fadeInUp', 'animate__zoomIn');
        card.classList.add('animate__animated', 'animate__rollOut');

        setTimeout(() => {
            window.location.href = link.href;
        }, 1000);
    }
</script>
@endsection
