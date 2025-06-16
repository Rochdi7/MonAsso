@extends('layouts.main')

@section('title', 'Dashboard')
@section('breadcrumb-item', 'Dashboard')
@section('breadcrumb-item-active', 'Home')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/jsvectormap.min.css') }}">
@endsection

@section('content')

    @if (!auth()->user()->hasVerifiedEmail())
        <div class="alert alert-warning">
            Your email is not verified yet. Please verify your email.
        </div>
    @endif


    <div class="row">

        {{-- Top Statistics Row --}}
        {{-- Total Associations --}}
        <div class="col-md-4 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden">
                <div class="card-body">
                    <img src="{{ URL::asset('build/images/widget/img-status-4.svg') }}" alt="img"
                        class="img-fluid img-bg" />
                    <h5 class="mb-4">Total Associations</h5>
                    <div class="d-flex align-items-center mt-3">
                        <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $totalAssociations }}</h3>
                    </div>
                    <p class="text-muted mb-2 text-sm mt-3">
                        Validated: {{ $validatedAssociations }} | Pending: {{ $pendingAssociations }}
                    </p>
                    <div class="progress" style="height: 7px">
                        <div class="progress-bar bg-brand-color-3" role="progressbar" style="width: 100%"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Members --}}
        <div class="col-md-4 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden">
                <div class="card-body">
                    <img src="{{ URL::asset('build/images/widget/img-status-5.svg') }}" alt="img"
                        class="img-fluid img-bg" />
                    <h5 class="mb-4">Total Members</h5>
                    <div class="d-flex align-items-center mt-3">
                        <h3 class="f-w-300 d-flex align-items-center m-b-0">{{ $totalUsers }}</h3>
                    </div>
                    <p class="text-muted mb-2 text-sm mt-3">
                        Active: {{ $activeUsers }} | Inactive: {{ $inactiveUsers }}
                    </p>
                    <div class="progress" style="height: 7px">
                        <div class="progress-bar bg-brand-color-3" role="progressbar" style="width: 100%"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Cotisations --}}
        <div class="col-md-4 col-sm-12">
            <div class="card statistics-card-1 overflow-hidden bg-brand-color-3">
                <div class="card-body">
                    <img src="{{ URL::asset('build/images/widget/img-status-6.svg') }}" alt="img"
                        class="img-fluid img-bg" />
                    <h5 class="mb-4 text-white">Total Cotisations</h5>
                    <div class="d-flex align-items-center mt-3">
                        <h3 class="text-white f-w-300 d-flex align-items-center m-b-0">
                            ${{ number_format($totalCotisations, 2) }}
                        </h3>
                    </div>
                    <p class="text-white text-opacity-75 mb-2 text-sm mt-3">Total Payments</p>
                    <div class="progress bg-white bg-opacity-10" style="height: 7px">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 100%" aria-valuenow="100"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Main Content and Sidebar Row -->
    <div class="row">
        {{-- LEFT COLUMN (Main Content) --}}
        <div class="col-lg-8">

            {{-- MEETING SUMMARY --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Meetings Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        {{-- Total Meetings --}}
                        <div class="col-md-6 col-xxl-3">
                            <div class="card border mb-0 shadow-sm rounded-3">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Total Meetings</h6>
                                        <span class="text-primary fw-bold small">All</span>
                                    </div>
                                    <h5 class="my-3">{{ $totalMeetings }}</h5>
                                    <p class="text-muted mb-0">Total created meetings</p>
                                </div>
                            </div>
                        </div>

                        {{-- Upcoming Meetings --}}
                        <div class="col-md-6 col-xxl-3">
                            <div class="card border mb-0 shadow-sm rounded-3">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Upcoming</h6>
                                        <span class="text-success fw-bold small">+{{ $upcomingPercentage ?? '0' }}%</span>
                                    </div>
                                    <h5 class="my-3">{{ $upcomingMeetings }}</h5>
                                    <p class="text-muted mb-0">Upcoming scheduled</p>
                                </div>
                            </div>
                        </div>

                        {{-- This Month --}}
                        <div class="col-md-6 col-xxl-3">
                            <div class="card border mb-0 shadow-sm rounded-3">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">This Month</h6>
                                        <span class="text-warning fw-bold small">+{{ $monthPercentage ?? '0' }}%</span>
                                    </div>
                                    <h5 class="my-3">{{ $meetingsThisMonth }}</h5>
                                    <p class="text-muted mb-0">Meetings in current month</p>
                                </div>
                            </div>
                        </div>

                        {{-- Completed --}}
                        <div class="col-md-6 col-xxl-3">
                            <div class="card border mb-0 shadow-sm rounded-3">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">Completed</h6>
                                        <span class="text-secondary fw-bold small">Done</span>
                                    </div>
                                    <h5 class="my-3">{{ $completedMeetings }}</h5>
                                    <p class="text-muted mb-0">Meetings completed</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Cashflow Bar Chart --}}
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h5 class="mb-1">Cashflow</h5>
                            <p>5.44% <span class="badge text-bg-success">5.44%</span></p>
                        </div>
                        <select class="form-select rounded-3 form-select-sm w-auto">
                            <option>Today</option>
                            <option>Weekly</option>
                            <option selected>Monthly</option>
                        </select>
                    </div>
                    <div id="cashflow-bar-chart"></div>
                </div>
            </div>


        </div>

        {{-- RIGHT COLUMN (Sidebar) --}}
        <div class="col-lg-4">
            {{-- Cotisation Status --}}
            <div class="col-12 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5>Cotisation Status</h5>
                    </div>
                    <div class="card-body">
                        <div id="cotisation-donut-chart"></div>
                        <ul class="list-group mt-4">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Paid</span>
                                <span class="badge bg-success">{{ $statusCounts['paid'] }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Pending</span>
                                <span class="badge bg-warning">{{ $statusCounts['pending'] }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Overdue</span>
                                <span class="badge bg-danger">{{ $statusCounts['overdue'] }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Rejected</span>
                                <span class="badge bg-secondary">{{ $statusCounts['rejected'] }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Uploaded Documents --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Uploaded Meeting Documents</h5>
                </div>
                <div class="card-body text-center">
                    <h3>{{ $uploadedDocuments }}</h3>
                    <p class="text-muted">Total Uploaded Files</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom Full-Width Row -->
    <div class="row">
        {{-- TOP ORGANIZERS --}}
        <div class="col-12">
            <div class="card table-card mt-4">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0">Top Organizers</h5>
                    <a href="#" class="btn btn-sm btn-link-primary">View All</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>Organizer</th>
                                    <th>Total Meetings</th>
                                    <th>This Month</th>
                                    <th>Last Meeting</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topOrganizers as $organizer)
                                                        <tr>
                                                            {{-- Organizer --}}
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="{{ $organizer->profile_image ?? asset('build/images/user/default.png') }}"
                                                                            alt="user image" class="img-radius wid-40" />
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-3">
                                                                        <h6 class="mb-0">{{ $organizer->name }}</h6>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            {{-- Total Meetings --}}
                                                            <td>{{ $organizer->total_meetings }}</td>

                                                            {{-- Meetings This Month --}}
                                                            <td>{{ $organizer->this_month_meetings }}</td>

                                                            {{-- Last Meeting --}}
                                                            <td>
                                                                {{ $organizer->last_meeting_date
                                    ? \Carbon\Carbon::parse($organizer->last_meeting_date)->format('d M Y')
                                    : '-' }}
                                                            </td>

                                                            {{-- Status --}}
                                                            <td>
                                                                @if ($organizer->is_active)
                                                                    <span class="badge text-bg-success">Active</span>
                                                                @else
                                                                    <span class="badge text-bg-danger">Inactive</span>
                                                                @endif
                                                            </td>

                                                            {{-- Actions --}}
                                                            <td>
                                                                <a href="{{ route('admin.membres.show', $organizer->id) }}"
                                                                    class="avtar avtar-xs btn-link-secondary">
                                                                    <i class="ti ti-eye f-20"></i>
                                                                </a>
                                                                <a href="{{ route('admin.membres.edit', $organizer->id) }}"
                                                                    class="avtar avtar-xs btn-link-secondary">
                                                                    <i class="ti ti-edit f-20"></i>
                                                                </a>
                                                                <form action="{{ route('admin.membres.destroy', $organizer->id) }}" method="POST"
                                                                    style="display:inline;">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit"
                                                                        class="avtar avtar-xs btn-link-secondary border-0 bg-transparent p-0"
                                                                        onclick="return confirm('Delete this organizer?')">
                                                                        <i class="ti ti-trash f-20"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">No data found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection


@section('scripts')
    <script src="{{ URL::asset('build/js/plugins/apexcharts.min.js') }}"></script>

    {{-- Cashflow Chart --}}
    <script>
        var options = {
            series: [{
                name: 'Cotisations',
                data: @json($cashflowData)
            }],
            chart: {
                type: 'bar',
                height: 250
            },
            xaxis: {
                categories: @json($cashflowLabels)
            }
        };
        var chart = new ApexCharts(document.querySelector("#cashflow-bar-chart"), options);
        chart.render();
    </script>

    {{-- Donut Chart --}}
    <script>
        var donutOptions = {
            series: [
                    {{ $statusCounts['paid'] }},
                    {{ $statusCounts['pending'] }},
                    {{ $statusCounts['overdue'] }},
                {{ $statusCounts['rejected'] }}
            ],
            chart: {
                type: 'donut',
                height: 300
            },
            labels: ['Paid', 'Pending', 'Overdue', 'Rejected'],
            colors: ['#28a745', '#ffc107', '#dc3545', '#6c757d'],
        };
        var donutChart = new ApexCharts(document.querySelector("#cotisation-donut-chart"), donutOptions);
        donutChart.render();
    </script>
@endsection