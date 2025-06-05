@extends('layouts.main')

@section('title', 'Create Meeting')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'New Meeting')
@section('page-animation', 'animate__rollIn')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/datepicker-bs5.min.css') }}">
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

            <form action="{{ route('admin.meetings.store') }}" enctype="multipart/form-data" method="POST"
                class="needs-validation" novalidate>
                @csrf

                <div id="meeting-form-card" class="card animate__animated animate__rollIn">
                    <div class="card-header">
                        <h5>New Meeting Form</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title') }}" required>
                                <div class="invalid-feedback">
                                    @error('title') {{ $message }} @else Please enter a title. @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="datetime" class="form-label">Date & Time</label>
                                <input type="datetime-local" class="form-control @error('datetime') is-invalid @enderror"
                                    id="datetime" name="datetime" value="{{ old('datetime') }}" required>
                                @error('datetime')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="documents" class="form-label">Attach Documents</label>
                                <input type="file" name="documents[]" multiple
                                    class="form-control @error('documents.*') is-invalid @enderror">
                                @error('documents.*')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3 col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="">Choose status...</option>
                                    <option value="0" @selected(old('status') == 0)>Pending</option>
                                    <option value="1" @selected(old('status') == 1)>Confirmed</option>
                                    <option value="2" @selected(old('status') == 2)>Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" name="location"
                                    class="form-control @error('location') is-invalid @enderror"
                                    value="{{ old('location') }}">
                                @error('location')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="association_id" class="form-label">Association</label>
                                @if(auth()->user()->hasRole('super_admin'))
                                    <select name="association_id"
                                        class="form-select @error('association_id') is-invalid @enderror" required>
                                        <option value="">Select association...</option>
                                        @foreach($associations as $association)
                                            <option value="{{ $association->id }}"
                                                @selected(old('association_id') == $association->id)>
                                                {{ $association->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="hidden" name="association_id" value="{{ auth()->user()->association_id }}">
                                    <input type="text" class="form-control" value="{{ auth()->user()->association->name }}"
                                        disabled>
                                @endif
                                @error('association_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="organizer_id" class="form-label">Organizer</label>
                                @if(auth()->user()->hasRole('super_admin'))
                                    <select name="organizer_id" class="form-select @error('organizer_id') is-invalid @enderror"
                                        required>
                                        <option value="">Select organizer...</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" @selected(old('organizer_id') == $user->id)>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="hidden" name="organizer_id" value="{{ auth()->id() }}">
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                                @endif
                                @error('organizer_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" rows="4"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('admin.meetings.index') }}" class="btn btn-secondary"
                            onclick="rollOutCard(event, this, 'meeting-form-card')">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Meeting</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/plugins/datepicker-full.min.js') }}"></script>
    <script>
        // DateTime Picker
        new Datepicker(document.querySelector('#datetime_picker'), {
            format: 'yyyy-mm-dd HH:mm',
            autohide: true,
            pickTime: true,
            minuteStep: 15
        });

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

        // RollOut animation on cancel
        function rollOutCard(event, link, cardId = 'meeting-form-card') {
            event.preventDefault();
            const card = document.getElementById(cardId);
            if (!card) return;

            card.classList.remove('animate__rollIn', 'animate__zoomIn', 'animate__fadeInUp');
            card.classList.add('animate__animated', 'animate__rollOut');

            setTimeout(() => {
                window.location.href = link.href;
            }, 1000);
        }
    </script>
@endsection