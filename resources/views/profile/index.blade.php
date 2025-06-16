@extends('layouts.main')

@section('title', 'Account Profile')
@section('breadcrumb-item', 'Users')
@section('breadcrumb-item-active', 'Account Profile')

@section('css')
@endsection

@section('content')
  <!-- [ Main Content ] start -->
  <div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
    {{-- Success Messages for both profile and password updates --}}
    @if (session('success'))
    <div class="alert alert-success" role="alert">
      {{ session('success') }}
    </div>
    @endif
    @if (session('status') === 'password-updated')
    <div class="alert alert-success" role="alert">
      Password updated successfully.
    </div>
    @endif


    {{-- Email Verification Alert --}}
    @if (!$user->hasVerifiedEmail())
    <div class="card bg-primary">
      <div class="card-body">
      <div class="d-flex align-items-center">
      <div class="flex-grow-1 me-3">
      <h3 class="text-white">Email Verification</h3>
      <p class="text-white text-opacity-75 text-opa mb-0">Your email is not confirmed. Please check your inbox.
        {{-- Point this to your resend verification route --}}
      <form method="POST" action="{{ route('verification.send') }}" style="display: inline;">
        @csrf
        <button type="submit" class="btn btn-link link-light p-0 m-0 align-baseline"><u>Resend
        confirmation</u></button>
      </form>
      </p>
      </div>
      <div class="flex-shrink-0">
      <img src="{{ URL::asset('build/images/application/img-accout-alert.png') }}" alt="img"
        class="img-fluid wid-80" />
      </div>
      </div>
      </div>
    </div>
    @endif

    <div class="row">
      <div class="col-lg-5 col-xxl-3">
      <div class="card overflow-hidden">
        <div class="card-body position-relative">
        <div class="text-center mt-3">
          <div class="chat-avtar d-inline-flex mx-auto">
          <img class="rounded-circle img-fluid wid-90 img-thumbnail"
            src="{{ $user->getFirstMediaUrl('profile_photo') ?: URL::asset('build/images/user/avatar-1.jpg') }}"
            alt="User image" />
          <i class="chat-badge bg-success me-2 mb-2"></i>
          </div>
          <h5 class="mb-0">{{ $user->name }}</h5>
          <p class="text-muted text-sm">
          Contact <a href="mailto:{{ $user->email }}" class="link-primary">{{ $user->email }}</a> 😍
          </p>
          <ul class="list-inline mx-auto my-4">
          {{-- These can be made dynamic --}}
          </ul>
          <div class="row g-3">
          {{-- These can be made dynamic --}}
          </div>
        </div>
        </div>
        {{-- [MODIFIED] Navigation with removed tabs --}}
        <div class="nav flex-column nav-pills list-group list-group-flush account-pills mb-0" id="user-set-tab"
        role="tablist" aria-orientation="vertical">
        <a class="nav-link list-group-item list-group-item-action active" id="user-set-profile-tab"
          data-bs-toggle="pill" href="#user-set-profile" role="tab" aria-controls="user-set-profile"
          aria-selected="true">
          <span class="f-w-500"><i class="ph-duotone ph-user-circle m-r-10"></i>Profile Overview</span>
        </a>
        <a class="nav-link list-group-item list-group-item-action" id="user-set-information-tab"
          data-bs-toggle="pill" href="#user-set-information" role="tab" aria-controls="user-set-information"
          aria-selected="false">
          <span class="f-w-500"><i class="ph-duotone ph-clipboard-text m-r-10"></i>Edit Information</span>
        </a>
        <a class="nav-link list-group-item list-group-item-action" id="user-set-password-tab" data-bs-toggle="pill"
          href="#user-set-password" role="tab" aria-controls="user-set-password" aria-selected="false">
          <span class="f-w-500"><i class="ph-duotone ph-key m-r-10"></i>Change Password</span>
        </a>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
        <h5>Personal information</h5>
        </div>
        <div class="card-body position-relative">
        <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
          <p class="mb-0 text-muted me-1">Email</p>
          <p class="mb-0">{{ $user->email }}</p>
        </div>
        <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
          <p class="mb-0 text-muted me-1">Phone</p>
          <p class="mb-0">{{ $user->phone ?? 'Not provided' }}</p>
        </div>
        <div class="d-inline-flex align-items-center justify-content-between w-100">
          <p class="mb-0 text-muted me-1">Location</p>
          <p class="mb-0">{{ $user->location ?? 'Not provided' }}</p>
        </div>
        </div>
      </div>
      </div>
      <div class="col-lg-7 col-xxl-9">
      <div class="tab-content" id="user-set-tabContent">
        {{-- Profile Overview Tab --}}
        <div class="tab-pane fade show active" id="user-set-profile" role="tabpanel"
        aria-labelledby="user-set-profile-tab">
        <div class="card alert alert-warning p-0">
          <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-grow-1 me-3">
            <h4 class="alert-heading">Change Your Password</h4>
            <p class="mb-2">For your security, we recommend changing your password regularly.</p>
            <a href="#user-set-password" class="alert-link" data-bs-toggle="pill">
              <u>Update your password now</u>
            </a>
            </div>
            <div class="flex-shrink-0">
            <img src="{{ URL::asset('build/images/application/img-accout-password-alert.png') }}"
              alt="Password Alert" class="img-fluid wid-80" />
            </div>
          </div>
          </div>
        </div>


        <div class="card">
          <div class="card-header">
          <h5>About me</h5>
          </div>
          <div class="card-body">
          <p class="mb-0">{{ $user->bio ?? 'Hello! Add a bio by editing your profile.' }}</p>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
          <h5>Personal Details</h5>
          </div>
          <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item px-0 pt-0">
            <div class="row">
              <div class="col-md-6">
              <p class="mb-1 text-muted">Full Name</p>
              <p class="mb-0">{{ $user->name }}</p>
              </div>
              <div class="col-md-6">
              <p class="mb-1 text-muted">Email</p>
              <p class="mb-0">{{ $user->email }}</p>
              </div>
            </div>
            </li>
            <li class="list-group-item px-0">
            <div class="row">
              <div class="col-md-6">
              <p class="mb-1 text-muted">Phone</p>
              <p class="mb-0">{{ $user->phone ?? 'Not provided' }}</p>
              </div>
              <div class="col-md-6">
              <p class="mb-1 text-muted">Location</p>
              <p class="mb-0">{{ $user->location ?? 'Not provided' }}</p>
              </div>
            </div>
            </li>
            <li class="list-group-item px-0 pb-0">
            <p class="mb-1 text-muted">Address</p>
            <p class="mb-0">{{ $user->address ?? 'Not provided' }}</p>
            </li>
          </ul>
          </div>
        </div>
        </div>

        {{-- Edit Information Tab --}}
        <div class="tab-pane fade" id="user-set-information" role="tabpanel"
        aria-labelledby="user-set-information-tab">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
          @csrf
          <div class="card">
          <div class="card-header">
            <h5>Personal Information</h5>
          </div>
          <div class="card-body">
            <div class="row">
            <div class="col-sm-6">
              <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name', $user->name) }}">
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="col-sm-6">
              <div class="mb-3">
              <label class="form-label">Profile Photo</label>
              <input type="file" class="form-control @error('profile_photo') is-invalid @enderror"
                name="profile_photo">
              @error('profile_photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="col-sm-12">
              <div class="mb-3">
              <label class="form-label">Bio</label>
              <textarea class="form-control @error('bio') is-invalid @enderror"
                name="bio">{{ old('bio', $user->bio) }}</textarea>
              @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            </div>
          </div>
          </div>
          <div class="card">
          <div class="card-header">
            <h5>Contact Information</h5>
          </div>
          <div class="card-body">
            <div class="row">
            <div class="col-sm-6">
              <div class="mb-3">
              <label class="form-label">Contact Phone</label>
              <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                value="{{ old('phone', $user->phone) }}">
              @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="col-sm-6">
              <div class="mb-3">
              <label class="form-label">Email <span class="text-danger">(cannot be changed)</span></label>
              <input type="email" class="form-control" value="{{ $user->email }}" disabled>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="mb-0">
              <label class="form-label">Address</label>
              <textarea class="form-control @error('address') is-invalid @enderror"
                name="address">{{ old('address', $user->address) }}</textarea>
              @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            </div>
          </div>
          </div>
          <div class="text-end btn-page">
          <button type="reset" class="btn btn-outline-secondary">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Profile</button>
          </div>
        </form>
        </div>

        {{-- [MODIFIED] Change Password Tab --}}
        <div class="tab-pane fade" id="user-set-password" role="tabpanel" aria-labelledby="user-set-password-tab">
        <form method="POST" action="{{ route('profile.updatePassword') }}">
          @csrf

          <div class="mb-3">
          <label for="current_password" class="form-label">Current Password</label>
          <input type="password" name="current_password" id="current_password"
            class="form-control @error('current_password') is-invalid @enderror" required>
          @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
          <label for="password" class="form-label">New Password</label>
          <input type="password" name="password" id="password"
            class="form-control @error('password') is-invalid @enderror" required>
          @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
          <label for="password_confirmation" class="form-label">Confirm New Password</label>
          <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
            required>
          @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="card-footer text-end">
          <button type="submit" class="btn btn-primary">Change Password</button>
          </div>
        </form>

        </div>

      </div>
      </div>
    </div>
    </div>
    <!-- [ sample-page ] end -->
  </div>
  <!-- [ Main Content ] end -->

@endsection