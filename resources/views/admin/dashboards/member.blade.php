@extends('layouts.main')

@section('title', 'My Dashboard')
@section('breadcrumb-item', 'Dashboard')
@section('breadcrumb-item-active', 'Home')

@section('css')
@endsection

@section('content')

    {{-- Notifications --}}
    <div class="alert alert-warning" role="alert">
        <i class="ti ti-alert-triangle me-2"></i>
        Your email is not verified yet. Please check your inbox for a verification link.
    </div>

    @if ($overdueTotal > 0 || $pendingTotal > 0)
        <div class="alert alert-danger" role="alert">
            <i class="ti ti-file-invoice me-2"></i>
            You have unpaid cotisation(s) due.
            <a href="{{ route('membre.cotisations.index') }}" class="alert-link">Please pay now</a> to remain an active
            member.
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">

            {{-- Profile --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('build/images/user/avatar-1.jpg') }}" alt="user image"
                                class="img-radius wid-60" />
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-1">Welcome, {{ auth()->user()->name }}!</h4>
                            <p class="mb-0 text-muted">Here's what's happening in your association.</p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('profile.index') }}" class="btn btn-primary d-inline-flex align-items-center">
                                <i class="ti ti-user me-2"></i>My Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cotisation History --}}
            <div class="card table-card mb-4">
                <div class="card-header">
                    <h5>My Cotisation History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Cycle</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($myCotisationsList as $cotisation)
                                    <tr>
                                        <td>{{ $cotisation->cycle }}</td>
                                        <td>{{ number_format($cotisation->amount, 2) }} MAD</td>
                                        <td>
                                            @if (!empty($cotisation->due_date) && $cotisation->due_date !== 'N/A')
                                                {{ \Carbon\Carbon::parse($cotisation->due_date)->format('M d, Y') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $badge = match ($cotisation->status) {
                                                    1 => 'bg-light-success',
                                                    0 => 'bg-light-warning',
                                                    2 => 'bg-light-danger',
                                                    3 => 'bg-light-secondary',
                                                    default => 'bg-light-secondary',
                                                };

                                                $statusLabel = match ($cotisation->status) {
                                                    0 => 'Pending',
                                                    1 => 'Paid',
                                                    2 => 'Overdue',
                                                    3 => 'Rejected',
                                                    default => 'Unknown',
                                                };
                                            @endphp
                                            <span class="badge {{ $badge }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            @if ($cotisation->status !== 1)
                                                <a href="{{ route('membre.cotisations.index') }}"
                                                    class="btn btn-sm btn-success d-inline-flex align-items-center">
                                                    <i class="ti ti-wallet me-1"></i>Pay Now
                                                </a>
                                            @else
                                                <a href="{{ route('membre.cotisations.index') }}"
                                                    class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                                                    <i class="ti ti-receipt me-1"></i>View Receipt
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            No cotisation history available.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            {{-- Activity Log --}}
            <div class="card table-card">
                <div class="card-header">
                    <h5>My Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Activity</th>
                                    <th class="text-end">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivities as $activity)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($activity->date)->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge bg-light-primary">{{ $activity->type }}</span>
                                        </td>
                                        <td class="text-end">{{ $activity->details }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No recent activities.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">

            {{-- Membership Status --}}
            <div class="card mb-4 bg-light-success text-center">
                <div class="card-body">
                    <h5 class="mb-2">Membership Status</h5>
                    <h3 class="text-success">ACTIVE</h3>
                    <p class="text-muted mb-0">Your payments are up to date. Thank you!</p>
                </div>
            </div>

            {{-- My Documents --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>My Documents</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-secondary">
                                    <i class="ti ti-file-text f-20"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Meeting Minutes - Q1 2024</h6>
                            </div>
                            <a href="{{ route('admin.meetings.index') }}" class="btn btn-icon btn-light-secondary"
                                title="Go to Meetings">
                                <i class="ti ti-download"></i>
                            </a>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-secondary">
                                    <i class="ti ti-file-text f-20"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Association Bylaws</h6>
                            </div>
                            <a href="{{ route('admin.meetings.index') }}" class="btn btn-icon btn-light-secondary"
                                title="Go to Meetings">
                                <i class="ti ti-download"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>


            {{-- Upcoming Meetings --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Upcoming Meetings</h5>
                    <a href="{{ route('admin.meetings.index') }}" class="btn btn-sm btn-link-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-primary">
                                    <i class="ti ti-calendar-event f-20"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Quarterly Review</h6>
                                <small class="text-muted">Thu, Apr 18, 2024 - 06:00 PM</small>
                            </div>
                            <a href="{{ route('admin.meetings.index') }}" class="btn btn-icon btn-light-secondary"
                                title="View Meetings">
                                <i class="ti ti-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Upcoming Events --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Upcoming Events</h5>
                    <a href="{{ route('membre.events.index') }}" class="btn btn-sm btn-link-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-info">
                                    <i class="ti ti-ticket f-20"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Annual Charity Gala</h6>
                                <small class="text-muted">Sat, Jun 15, 2024</small>
                            </div>
                            <a href="{{ route('membre.events.index') }}" class="btn btn-icon btn-light-secondary"
                                title="View Events">
                                <i class="ti ti-arrow-right"></i>
                            </a>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-info">
                                    <i class="ti ti-users f-20"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Community Workshop</h6>
                                <small class="text-muted">Tue, Jul 09, 2024</small>
                            </div>
                            <a href="{{ route('membre.events.index') }}" class="btn btn-icon btn-light-secondary"
                                title="View Events">
                                <i class="ti ti-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('scripts')
@endsection
