@extends('layouts.main')

@section('title', 'Edit Membre')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Edit Membre')
@section('page-animation', 'animate__rollIn')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/animate.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        @if ($errors->any())
            <div class="alert alert-danger animate__animated animate__shakeX">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.membres.update', $membre->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            <div id="membre-edit-card" class="card animate__animated animate__rollIn">
                <div class="card-header">
                    <h5>Edit Membre</h5>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $membre->name) }}" required>
                            <div class="invalid-feedback">
                                @error('name') {{ $message }} @else Please enter the member's name. @enderror
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $membre->phone) }}" required>
                            <div class="invalid-feedback">
                                @error('phone') {{ $message }} @else Please enter a valid phone number. @enderror
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">Choose...</option>
                                <option value="super_admin" @selected(old('role', $membre->role) == 'super_admin')>Super Admin</option>
                                <option value="admin" @selected(old('role', $membre->role) == 'admin')>Admin</option>
                                <option value="membre" @selected(old('role', $membre->role) == 'membre')>Membre</option>
                            </select>
                            @error('role')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="association_id" class="form-label">Association</label>
                            <select name="association_id" class="form-select @error('association_id') is-invalid @enderror" required>
                                <option value="">Select Association</option>
                                @foreach($associations as $id => $name)
                                    <option value="{{ $id }}" @selected(old('association_id', $membre->association_id) == $id)>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('association_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="profile_photo" class="form-label">Change Profile Photo</label>
                            <input type="file" name="profile_photo" class="form-control @error('profile_photo') is-invalid @enderror" accept="image/*">
                            @error('profile_photo')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror

                            @if($membre->getFirstMedia('profile_photo'))
                                @php
                                    $media = $membre->getFirstMedia('profile_photo');
                                    $short = \Illuminate\Support\Str::limit(pathinfo($media->file_name, PATHINFO_FILENAME), 8, '');
                                @endphp
                                <small class="text-muted d-block mt-2">
                                    Current:
                                    <a href="{{ $media->getUrl() }}" target="_blank">View Photo ({{ $short }})</a>
                                </small>
                            @endif
                        </div>

                        <div class="mb-3 col-md-3">
                            <label class="form-label">Is Active</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="activeCheck"
                                    @checked(old('is_active', $membre->is_active))>
                                <label class="form-check-label" for="activeCheck">Active Member</label>
                            </div>
                        </div>

                        <div class="mb-3 col-md-3">
                            <label class="form-label">Is Admin</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_admin" value="1" id="adminCheck"
                                    @checked(old('is_admin', $membre->is_admin))>
                                <label class="form-check-label" for="adminCheck">Admin Privilege</label>
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="availability" class="form-label">Availability</label>
                            <textarea name="availability" class="form-control" rows="2">{{ old('availability', $membre->availability) }}</textarea>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="skills" class="form-label">Skills</label>
                            <textarea name="skills" class="form-control" rows="2">{{ old('skills', $membre->skills) }}</textarea>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="password" class="form-label">New Password (optional)</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('admin.membres.index') }}" class="btn btn-secondary" onclick="rollOutCard(event, this, 'membre-edit-card')">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Membre</button>
                </div>
            </div>
        </form>
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

    function rollOutCard(event, link, cardId = 'membre-edit-card') {
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
