@extends('layouts.AuthLayout')

@section('title', 'Register')

@section('content')
<div class="auth-form">
    <div class="card my-5">
        <div class="card-body">
            <div class="text-center">
                <img src="{{ URL::asset('build/images/authentication/img-auth-register.png') }}" alt="Register" class="img-fluid mb-3">
                <h4 class="f-w-500 mb-1">Register your association</h4>
                <p class="mb-3">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="link-primary">Log in</a>
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row g-3">
                    {{-- Association Name --}}
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="association_name" class="form-control @error('association_name') is-invalid @enderror"
                                id="association_name" placeholder="Association Name" value="{{ old('association_name') }}" required>
                            <label for="association_name">Association Name</label>
                            @error('association_name')
                                <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- Association Address --}}
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="association_address" class="form-control @error('association_address') is-invalid @enderror"
                                id="association_address" placeholder="Address" value="{{ old('association_address') }}" required>
                            <label for="association_address">Address</label>
                            @error('association_address')
                                <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- Association Email --}}
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" name="association_email" class="form-control @error('association_email') is-invalid @enderror"
                                id="association_email" placeholder="Association Email" value="{{ old('association_email') }}" required>
                            <label for="association_email">Association Email</label>
                            @error('association_email')
                                <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- Owner Name --}}
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" placeholder="Owner Name" value="{{ old('name') }}" required>
                            <label for="name">Owner's Full Name</label>
                            @error('name')
                                <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- Personal Email --}}
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" placeholder="Owner Email" value="{{ old('email') }}" required>
                            <label for="email">Owner's Email</label>
                            @error('email')
                                <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                id="phone" placeholder="Phone" value="{{ old('phone') }}" required>
                            <label for="phone">Phone Number</label>
                            @error('phone')
                                <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" placeholder="Password" required>
                            <label for="password">Password</label>
                            @error('password')
                                <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password" name="password_confirmation" class="form-control"
                                id="password_confirmation" placeholder="Confirm Password" required>
                            <label for="password_confirmation">Confirm Password</label>
                        </div>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </form>

           
        </div>
    </div>
</div>
@endsection
