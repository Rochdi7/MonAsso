@extends('layouts.main')

@section('title', 'My Dashboard')
@section('breadcrumb-item', 'Dashboard')
@section('breadcrumb-item-active', 'Home')

@section('css')
@endsection

@section('content')

    {{-- Dynamic Email verification alert --}}
    @if (!auth()->user()->hasVerifiedEmail())
        <div class="alert alert-warning" role="alert">
            <i class="ti ti-alert-triangle me-2"></i>
            Your email is not verified yet. Please check your inbox for a verification link.
        </div>
    @endif

    {{-- Dynamic unpaid cotisation alert --}}
    @php
        $overdueAmount = $myCotisations[\App\Models\Cotisation::STATUS_OVERDUE] ?? 0;
        $pendingAmount = $myCotisations[\App\Models\Cotisation::STATUS_PENDING] ?? 0;
    @endphp

    @if ($overdueAmount > 0 || $pendingAmount > 0)
        <div class="alert alert-danger" role="alert">
            <i class="ti ti-file-invoice me-2"></i>
            You have unpaid cotisations totalling:
            <strong>{{ number_format($overdueAmount + $pendingAmount, 2, '.', ' ') }} MAD</strong>.
            <a href="{{ route('admin.cotisations.index') }}" class="alert-link">Pay now</a> to remain active.
        </div>
    @endif

    <div class="row">
        {{-- LEFT COLUMN (Main Content) --}}
        <div class="col-lg-8">

            {{-- Profile Summary Card --}}
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

            {{-- My Cotisation History --}}
            <div class="card table-card mb-4">
                <div class="card-header">
                    <h5>My Cotisation Summary</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="ti ti-circle-filled text-success me-2"></i> Paid</span>
                            <span
                                class="fw-bold">{{ number_format($myCotisations[\App\Models\Cotisation::STATUS_PAID] ?? 0, 2, '.', ' ') }}
                                MAD</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="ti ti-circle-filled text-warning me-2"></i> Pending</span>
                            <span
                                class="fw-bold">{{ number_format($myCotisations[\App\Models\Cotisation::STATUS_PENDING] ?? 0, 2, '.', ' ') }}
                                MAD</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="ti ti-circle-filled text-danger me-2"></i> Overdue</span>
                            <span
                                class="fw-bold">{{ number_format($myCotisations[\App\Models\Cotisation::STATUS_OVERDUE] ?? 0, 2, '.', ' ') }}
                                MAD</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- My Activity Log --}}
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
                                {{-- Example static data. Replace with real data later --}}
                                <tr>
                                    <td>{{ now()->subDays(2)->format('M d, Y') }}</td>
                                    <td><span class="badge bg-light-info">Joined Event</span></td>
                                    <td class="text-end">Annual Charity Gala</td>
                                </tr>
                                <tr>
                                    <td>{{ now()->subDays(10)->format('M d, Y') }}</td>
                                    <td><span class="badge bg-light-primary">Attended Meeting</span></td>
                                    <td class="text-end">Quarterly Review</td>
                                </tr>
                                <tr>
                                    <td>{{ now()->subYear()->format('M d, Y') }}</td>
                                    <td><span class="badge bg-light-success">Paid Cotisation</span></td>
                                    <td class="text-end">Annual Dues {{ now()->subYear()->year }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN (Sidebar) --}}
        <div class="col-lg-4">

            {{-- Membership Status Card --}}
            <div class="card mb-4 {{ auth()->user()->is_active ? 'bg-light-success' : 'bg-light-danger' }}">
                <div class="card-body text-center">
                    <h5 class="mb-2">Membership Status</h5>
                    <h3 class="{{ auth()->user()->is_active ? 'text-success' : 'text-danger' }}">
                        {{ auth()->user()->is_active ? 'ACTIVE' : 'INACTIVE' }}
                    </h3>
                    <p class="text-muted mb-0">
                        {{ auth()->user()->is_active ? 'Your payments are up to date. Thank you!' : 'Your membership is currently inactive. Please settle your dues.' }}
                    </p>
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
                                <div class="avtar avtar-s bg-light-secondary"><i class="ti ti-file-text f-20"></i></div>
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
                                <div class="avtar avtar-s bg-light-secondary"><i class="ti ti-file-text f-20"></i></div>
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
                                <div class="avtar avtar-s bg-light-primary"><i class="ti ti-calendar-event f-20"></i></div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Quarterly Review</h6>
                                <small class="text-muted">Thu, Apr 18, 2024 - 06:00 PM</small>
                            </div>
                            <a href="{{ route('admin.meetings.index') }}" class="btn btn-icon btn-light-secondary">
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
                    <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-link-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-info"><i class="ti ti-ticket f-20"></i></div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Annual Charity Gala</h6>
                                <small class="text-muted">Sat, Jun 15, 2024</small>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <span class="badge bg-light-success">Joined</span>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-s bg-light-info"><i class="ti ti-users f-20"></i></div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Community Workshop</h6>
                                <small class="text-muted">Tue, Jul 09, 2024</small>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <span class="badge bg-light-primary">Interested</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
@endsection
