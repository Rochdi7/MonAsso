@extends('layouts.main')

@section('title', 'Edit Cotisation')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'Edit Cotisation')
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

            <form action="{{ route('admin.cotisations.update', $cotisation) }}" method="POST" class="needs-validation"
                novalidate>
                @csrf
                @method('PUT')

                <div id="cotisation-form-card" class="card animate__animated animate__rollIn">
                    <div class="card-header">
                        <h5>Edit Cotisation</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="mb-3 col-md-6">
                                <label for="user_id" class="form-label">User</label>
                                <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                    <option value="">Select user...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @selected(old('user_id', $cotisation->user_id) == $user->id)>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="association_id" class="form-label">Association</label>
                                <select name="association_id"
                                    class="form-select @error('association_id') is-invalid @enderror" required>
                                    <option value="">Select association...</option>
                                    @foreach($associations as $association)
                                        <option value="{{ $association->id }}" @selected(old('association_id', $cotisation->association_id) == $association->id)>
                                            {{ $association->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('association_id')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="year" class="form-label">Year</label>
                                <input type="number" name="year" class="form-control @error('year') is-invalid @enderror"
                                    value="{{ old('year', $cotisation->year) }}" required>
                                @error('year')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="amount" class="form-label">Amount (MAD)</label>
                                <input type="number" step="0.01" name="amount"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount', $cotisation->amount) }}" required>
                                @error('amount')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="">Select status...</option>
                                    <option value="0" @selected(old('status', $cotisation->status) == 0)>Pending</option>
                                    <option value="1" @selected(old('status', $cotisation->status) == 1)>Paid</option>
                                    <option value="2" @selected(old('status', $cotisation->status) == 2)>Overdue</option>
                                    <option value="3" @selected(old('status', $cotisation->status) == 3)>Rejected</option>
                                </select>
                                @error('status')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="paid_at" class="form-label">Paid At</label>
                                <input type="datetime-local" name="paid_at"
                                    class="form-control @error('paid_at') is-invalid @enderror"
                                    value="{{ old('paid_at', optional($cotisation->paid_at)->format('Y-m-d\TH:i')) }}">
                                @error('paid_at')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="receipt_number" class="form-label">Receipt Number</label>
                                <input type="text" name="receipt_number"
                                    class="form-control @error('receipt_number') is-invalid @enderror"
                                    value="{{ old('receipt_number', $cotisation->receipt_number) }}">
                                @error('receipt_number')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            @php $authUser = auth()->user(); @endphp

                            <div class="mb-3 col-md-6">
                                <label for="approved_by" class="form-label">Approved By</label>

                                @if($authUser->hasRole('superadmin'))
                                    <select name="approved_by" class="form-select @error('approved_by') is-invalid @enderror">
                                        <option value="">(Optional)</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" @selected(old('approved_by', $cotisation->approved_by) == $user->id)>
                                                {{ $user->name }} @if($user->hasRole('superadmin')) (Super Admin) @endif
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="hidden" name="approved_by" value="{{ $authUser->id }}">
                                    <input type="text" class="form-control" value="{{ $authUser->name }}" readonly disabled>
                                @endif

                                @error('approved_by')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('admin.cotisations.index') }}" class="btn btn-secondary"
                            onclick="rollOutCard(event, this, 'cotisation-form-card')">Cancel</a>
                        @if (auth()->user()->hasAnyRole(['admin', 'superadmin', 'board']) && (auth()->user()->hasRole('superadmin') || (int) $cotisation->association_id === (int) auth()->user()->association_id))
                            <button type="submit" class="btn btn-primary">Update Cotisation</button>
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
            });
        })();

        function rollOutCard(event, link, cardId = 'cotisation-form-card') {
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