@extends('layouts.main')

@section('title', 'Create Event')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'New Event')
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

            <form action="{{ route('admin.events.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <div id="event-form-card" class="card animate__animated animate__rollIn">
                    <div class="card-header">
                        <h5>New Event Form</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="title" class="form-label">Event Title</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title') }}" required>
                                <div class="invalid-feedback">
                                    @error('title') {{ $message }} @else Please enter the event title. @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" name="location"
                                    class="form-control @error('location') is-invalid @enderror"
                                    value="{{ old('location') }}">
                                <div class="invalid-feedback">
                                    @error('location') {{ $message }} @else Please enter the location. @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="start_datetime" class="form-label">Start Date & Time</label>
                                <div class="input-group">
                                    <input type="datetime-local" name="start_datetime"
                                        class="form-control @error('start_datetime') is-invalid @enderror"
                                        value="{{ old('start_datetime') }}" required>
                                    <span class="input-group-text"><i class="feather icon-clock"></i></span>
                                </div>
                                @error('start_datetime')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="end_datetime" class="form-label">End Date & Time</label>
                                <div class="input-group">
                                    <input type="datetime-local" name="end_datetime"
                                        class="form-control @error('end_datetime') is-invalid @enderror"
                                        value="{{ old('end_datetime') }}" required>
                                    <span class="input-group-text"><i class="feather icon-clock"></i></span>
                                </div>
                                @error('end_datetime')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="0" @selected(old('status') == 0)>⏳ Pending</option>
                                    <option value="1" @selected(old('status') == 1)>✔ Confirmed</option>
                                    <option value="2" @selected(old('status') == 2)>✖ Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            @php $auth = $authUser; @endphp

                            @if($auth->hasRole('superadmin'))
                                <div class="mb-3 col-md-6">
                                    <label for="association_id" class="form-label">Association</label>
                                    <select name="association_id"
                                        class="form-select @error('association_id') is-invalid @enderror" required>
                                        <option value="">Choose association...</option>
                                        @foreach($associations as $id => $name)
                                            <option value="{{ $id }}" @selected(old('association_id') == $id)>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('association_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            @else
                                <input type="hidden" name="association_id" value="{{ $auth->association_id }}">
                            @endif


                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" rows="4"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Enter description...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary"
                            onclick="rollOutCard(event, this, 'event-form-card')">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Event</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
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

        function rollOutCard(event, link, cardId = 'event-form-card') {
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