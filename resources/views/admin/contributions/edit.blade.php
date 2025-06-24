@extends('layouts.main')

@section('title', 'Edit Contribution')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Edit Contribution')
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

        <form action="{{ route('admin.contributions.update', $contribution) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            <div id="contribution-form-card" class="card animate__animated animate__rollIn">
                <div class="card-header">
                    <h5>Edit Contribution</h5>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="mb-3 col-md-6">
                            <label for="type" class="form-label">Contribution Type</label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="1" @selected(old('type', $contribution->type) == 1)>Subvention</option>
                                <option value="2" @selected(old('type', $contribution->type) == 2)>Don</option>
                            </select>
                            @error('type')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="amount" class="form-label">Amount (MAD)</label>
                            <input type="number" step="0.01" name="amount"
                                   class="form-control @error('amount') is-invalid @enderror"
                                   value="{{ old('amount', $contribution->amount) }}" required>
                            @error('amount')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(isset($associations) && $associations->count())
                            <div class="mb-3 col-md-6">
                                <label for="association_id" class="form-label">Association</label>
                                <select name="association_id"
                                        class="form-select @error('association_id') is-invalid @enderror" required>
                                    @foreach($associations as $id => $name) {{-- Changed to $id => $name for pluck() --}}
                                        <option value="{{ $id }}"
                                            @selected(old('association_id', $contribution->association_id) == $id)>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('association_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <div class="mb-3 col-md-6">
                            <label for="received_at" class="form-label">Received At</label>
                            <input type="date" name="received_at"
                                   class="form-control @error('received_at') is-invalid @enderror"
                                   value="{{ old('received_at', optional($contribution->received_at)->format('Y-m-d')) }}">
                            @error('received_at')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" rows="4"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Enter description...">{{ old('description', $contribution->description) }}</textarea>
                            @error('description')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <a href="{{ route('admin.contributions.index') }}" class="btn btn-secondary"
                       onclick="rollOutCard(event, this, 'contribution-form-card')">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Contribution</button>
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

    function rollOutCard(event, link, cardId = 'contribution-form-card') {
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
