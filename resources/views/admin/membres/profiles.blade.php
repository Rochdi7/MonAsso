@extends('layouts.main')

@section('title', 'Member Profile')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'User Card')

@section('css')
@endsection

@section('content')

<div class="row justify-content-center">
  <div class="col-md-8 col-xl-6">
    <div class="card user-card">
      <div class="card-body">

        <!-- User Cover -->
        <div class="user-cover-bg">
          <img src="{{ URL::asset('build/images/application/img-user-cover-1.jpg') }}" alt="cover" class="img-fluid" />
          <div class="cover-data">
            <div class="d-inline-flex align-items-center">
              <i class="ph-duotone ph-star text-warning me-1"></i>
              {{ strtoupper($user->getRoleNames()->first() ?? 'N/A') }}
            </div>
          </div>
        </div>

        <!-- Avatar -->
        <div class="chat-avtar card-user-image">
          @if($user->getFirstMediaUrl('profile_photo'))
            <img src="{{ $user->getFirstMediaUrl('profile_photo') }}" alt="photo" class="img-thumbnail rounded-circle" />
          @else
            <img src="{{ asset('build/images/user/avatar-1.jpg') }}" alt="photo" class="img-thumbnail rounded-circle" />
          @endif
          <i class="chat-badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}"></i>
        </div>

        <!-- Name + Info -->
        <div class="d-flex">
          <div class="flex-grow-1 ms-2 text-center">
            <h5 class="mb-1">{{ $user->name }}</h5>
            <p class="text-muted text-sm mb-0">{{ $user->email }}</p>
            <p class="text-muted text-sm mb-0">📞 {{ $user->phone ?? '-' }}</p>
            <p class="text-muted text-sm mb-0"><strong>Association:</strong> {{ $user->association?->name ?? 'N/A' }}</p>
          </div>
        </div>

        <!-- Extra Actions -->
        <div class="saprator my-2"><span>Actions</span></div>
        <div class="d-flex justify-content-center gap-2">
    <a href="{{ route('admin.cotisations.create', ['user_id' => $user->id]) }}" class="btn btn-outline-primary">
        ➕ Add Cotisation
    </a>
    <a href="{{ route('admin.membres.edit', $user->id) }}" class="btn btn-outline-secondary">
        ✎ Edit
    </a>
    <a href="{{ route('admin.membres.index') }}" class="btn btn-outline-dark">
        ← Back to List
    </a>
</div>


      </div>
    </div>
  </div>
</div>

@endsection
