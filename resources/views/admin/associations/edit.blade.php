@extends('layouts.main')

@section('title', 'Edit Association')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Edit Association')
@section('page-animation', 'animate__rollIn')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/datepicker-bs5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/animate.min.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{-- Global error alert --}}
            @if ($errors->any())
                <div class="alert alert-danger animate__animated animate__shakeX">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.associations.update', $association->id) }}" method="POST"
                enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <div id="association-form-card" class="card animate__animated animate__rollIn">
                    <div class="card-header">
                        <h5>Edit Association</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Association Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $association->name) }}" required>
                                <div class="invalid-feedback">
                                    @error('name') {{ $message }} @else Please enter the association name. @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $association->email) }}" required>
                                <div class="invalid-feedback">
                                    @error('email') {{ $message }} @else Please enter a valid email address. @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address"
                                    class="form-control @error('address') is-invalid @enderror"
                                    value="{{ old('address', $association->address) }}" required>
                                <div class="invalid-feedback">
                                    @error('address') {{ $message }} @else Please enter an address. @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="creation_date" class="form-label">Creation Date</label>
                                <div class="input-group">
                                    <input type="text" id="creation_date_picker" name="creation_date"
                                        class="form-control @error('creation_date') is-invalid @enderror"
                                        value="{{ old('creation_date', $association->creation_date) }}" placeholder="Select date" autocomplete="off">
                                    <span class="input-group-text">
                                        <i class="feather icon-calendar"></i>
                                    </span>
                                </div>
                                @error('creation_date')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="announcement_status" class="form-label">Announcement Status</label>
                                <select name="announcement_status"
                                    class="form-select @error('announcement_status') is-invalid @enderror">
                                    <option value="">Choose...</option>
                                    <option value="pending" @selected(old('announcement_status', $association->announcement_status) == 'pending')>Pending</option>
                                    <option value="active" @selected(old('announcement_status', $association->announcement_status) == 'active')>Active</option>
                                    <option value="suspended" @selected(old('announcement_status', $association->announcement_status) == 'suspended')>Suspended</option>
                                </select>
                                @error('announcement_status')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="logo" class="form-label">Change Logo (optional)</label>
                                <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                                    accept="image/*">
                                @error('logo')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror

                                @if($association->getFirstMedia('logos'))
                                    @php
                                        $media = $association->getFirstMedia('logos');
                                        $short = Str::limit(pathinfo($media->file_name, PATHINFO_FILENAME), 8, '');
                                    @endphp
                                    <small class="text-muted d-block mt-2">
                                        Current:
                                        <a href="{{ route('media.custom', ['id' => $media->id, 'filename' => $media->file_name]) }}"
                                            target="_blank">
                                            View Logo ({{ $short }})
                                        </a>
                                    </small>
                                @endif
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Validation</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_validated" value="1"
                                        id="validatedCheck" @checked(old('is_validated', $association->is_validated))>
                                    <label class="form-check-label" for="validatedCheck">
                                        Is Validated
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('admin.associations.index') }}" class="btn btn-secondary"
                            onclick="rollOutCard(event, this, 'association-form-card')">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Association</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/plugins/datepicker-full.min.js') }}"></script>
    <script>
        // Initialize datepicker
        new Datepicker(document.querySelector('#creation_date_picker'), {
            buttonClass: 'btn',
            format: 'yyyy-mm-dd',
            autohide: true
        });

        // Bootstrap validation trigger
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

        // RollOut animation on Cancel
        function rollOutCard(event, link, cardId = 'association-form-card') {
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