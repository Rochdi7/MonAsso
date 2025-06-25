@extends('layouts.main')

@section('title', 'Edit Expense')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Edit Expense')
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

            <form action="{{ route('admin.expenses.update', $expense) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <div id="expense-form-card" class="card animate__animated animate__rollIn">
                    <div class="card-header">
                        <h5>Edit Expense</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="mb-3 col-md-6">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $expense->title) }}" required>
                                <div class="invalid-feedback">
                                    @error('title') {{ $message }} @else Please enter the expense title. @enderror
                                </div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="amount" class="form-label">Amount (MAD)</label>
                                <input type="number" step="0.01" name="amount"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount', $expense->amount) }}" required>
                                <div class="invalid-feedback">
                                    @error('amount') {{ $message }} @else Please enter the amount. @enderror
                                </div>
                            </div>

                            @php $authUser = auth()->user(); @endphp

                            @if($authUser->hasRole('superadmin'))
                                <div class="mb-3 col-md-6">
                                    <label for="association_id" class="form-label">Association</label>
                                    <select name="association_id"
                                        class="form-select @error('association_id') is-invalid @enderror" required>
                                        @foreach($associations as $id => $name)
                                            <option value="{{ $id }}" @selected(old('association_id', $expense->association_id) == $id)>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('association_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            @else
                                <input type="hidden" name="association_id" value="{{ $authUser->association_id }}">
                            @endif



                            <div class="mb-3 col-md-6">
                                <label for="spent_at" class="form-label">Spent At</label>
                                <input type="date" name="spent_at"
                                    class="form-control @error('spent_at') is-invalid @enderror"
                                    value="{{ old('spent_at', optional($expense->spent_at)->format('Y-m-d')) }}">
                                @error('spent_at')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" rows="4"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Optional description...">{{ old('description', $expense->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('admin.expenses.index') }}" class="btn btn-secondary"
                            onclick="rollOutCard(event, this, 'expense-form-card')">Cancel</a>
                        @if (auth()->user()->hasAnyRole(['admin', 'superadmin', 'board']) && (auth()->user()->hasRole('superadmin') || auth()->user()->association_id === $expense->association_id))
                            <button type="submit" class="btn btn-primary">Update Expense</button>
                        @endif
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

        function rollOutCard(event, link, cardId = 'expense-form-card') {
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