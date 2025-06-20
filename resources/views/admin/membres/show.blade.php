@extends('layouts.main')

@section('title', 'Member Profile')
@section('breadcrumb-item', 'Administration')
@section('breadcrumb-item-active', 'User Card')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('build/css/plugins/style.css') }}">
@endsection

@section('content')
<div class="row">
  <!-- Left: User Card -->
  <div class="col-md-5">
    <div class="card user-card shadow-sm">
      <div class="card-body">
        <!-- User Cover -->
        <div class="user-cover-bg rounded">
          <img src="{{ URL::asset('build/images/application/img-user-cover-1.jpg') }}" alt="cover" class="img-fluid rounded" />
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

        <!-- User Info -->
        <div class="d-flex mb-3">
          <div class="flex-grow-1 ms-2 text-center">
            <h5 class="mb-1">{{ $user->name }}</h5>
            <p class="text-muted text-sm mb-0">{{ $user->email }}</p>
            <p class="text-muted text-sm mb-0">📞 {{ $user->phone ?? '-' }}</p>
            <p class="text-muted text-sm mb-0">
              <strong>Association:</strong> {{ $user->association?->name ?? 'N/A' }}
            </p>
          </div>
          <div class="flex-shrink-0">
            <a href="{{ route('admin.membres.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
          </div>
        </div>

        <!-- Actions -->
        <div class="saprator my-3"><span>Actions</span></div>
        <div class="d-grid gap-2">
          <a href="{{ route('admin.cotisations.create', ['user_id' => $user->id]) }}" class="btn btn-outline-primary w-100">
            <i data-feather="plus"></i> Add Cotisation
          </a>
          <a href="{{ route('admin.membres.index') }}" class="btn btn-outline-dark w-100">
            ← Back to List
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Right: Cotisation History Table -->
  <div class="col-md-7">
    <div class="card table-card shadow-sm">
      <div class="card-header d-flex align-items-center justify-content-between py-3">
        <h5 class="mb-0">Cotisation History</h5>
      </div>

      <div class="card-body">
        @if($cotisations->isEmpty())
          <p class="text-muted">No cotisations found for this user.</p>
        @else
          <div class="table-responsive">
            <table class="table table-hover" id="cotisation-history-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Date/Time</th>
                  <th>Amount</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($cotisations->sortByDesc('created_at')->values() as $index => $cotisation)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                      {{ $cotisation->created_at->format('Y/m/d') }}
                      <span class="text-muted text-sm d-block">{{ $cotisation->created_at->format('h:i A') }}</span>
                    </td>
                    <td>{{ number_format($cotisation->amount, 2) }} MAD</td>
                    <td>
                      @if($cotisation->status === 'paid')
                        <span class="badge text-bg-success">Paid</span>
                      @else
                        <span class="badge text-bg-warning">Not Paid</span>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ URL::asset('build/js/plugins/simple-datatables.js') }}"></script>
<script>
  const dataTable = new simpleDatatables.DataTable('#cotisation-history-table', {
    perPage: 5,
    sortable: true
  });
</script>
@endsection
