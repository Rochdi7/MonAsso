@extends('layouts.main')

@section('title', 'Board Dashboard')
@section('breadcrumb-item', 'Dashboard')
@section('breadcrumb-item-active', 'Association Overview')

@section('css')
    {{-- ApexCharts is needed for the charts --}}
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/jsvectormap.min.css') }}">
@endsection

@section('content')

    <!-- Top Row: Key Performance Indicators (KPIs) -->
    <div class="row">
        {{-- Total Members --}}
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-primary"><i class="ti ti-users f-20"></i></div>
                        <div class="ms-3"><h6 class="mb-0">Total Members</h6></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0">{{ $users['total'] }}</h4>
                        <span class="badge bg-light-primary">Active: {{ $users['active'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Meeting Attendance --}}
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-info"><i class="ti ti-calendar-stats f-20"></i></div>
                        <div class="ms-3"><h6 class="mb-0">Meeting Attendance (Avg)</h6></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0">
                            {{ $users['total'] > 0 ? round(($meetings['held'] > 0 ? ($meetings['held'] / $users['total']) * 100 : 0), 1) : 0 }}%
                        </h4>
                        <span class="badge bg-light-success"><i class="ti ti-arrow-up"></i> +5%</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cotisations Collected (YTD) --}}
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-success"><i class="ti ti-receipt-2 f-20"></i></div>
                        <div class="ms-3"><h6 class="mb-0">Cotisations (YTD)</h6></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0">{{ number_format($cotisations['total'], 0, '.', ' ') }} MAD</h4>
                        <span class="badge bg-light-secondary">Target: 100,000 MAD</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Upcoming Events --}}
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-warning"><i class="ti ti-ticket f-20"></i></div>
                        <div class="ms-3"><h6 class="mb-0">Upcoming Events</h6></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0">{{ $events['active'] }}</h4>
                        <span class="badge bg-light-warning">Next: 15 Days</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content and Sidebar Row -->
    <div class="row">
        {{-- LEFT COLUMN (Main Content) --}}
        <div class="col-lg-8">

            {{-- Financial Performance Chart --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Financial Performance (Last 6 Months)</h5>
                    <div class="dropdown">
                        <a class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical f-18"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#"><i class="ti ti-report-analytics me-2"></i>View Full Report</a>
                            <a class="dropdown-item" href="#"><i class="ti ti-file-download me-2"></i>Export as PDF</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="financial-performance-chart"></div>
                </div>
            </div>

            {{-- Meeting Performance Summary --}}
            <div class="card table-card mt-4">
                <div class="card-header">
                    <h5>Recent Meeting Performance</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Meeting Title</th>
                                    <th>Date</th>
                                    <th>Attendees</th>
                                    <th>Participation Rate</th>
                                    <th class="text-end">View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentActivities as $activity)
                                    <tr>
                                        <td>{{ $activity->details }}</td>
                                        <td>{{ $activity->activity_time->format('M d, Y') }}</td>
                                        <td>N/A</td>
                                        <td><span class="text-success">--</span></td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-icon btn-light-secondary"><i class="ti ti-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($recentActivities->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No recent meetings.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN (Sidebar) --}}
        <div class="col-lg-4">

            {{-- Cotisation Status --}}
            <div class="card h-100">
                <div class="card-header">
                    <h5>Cotisation Status (Current Cycle)</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <div id="cotisation-status-chart" class="mt-3"></div>
                    <ul class="list-group list-group-flush mt-auto">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center">
                                <i class="ti ti-circle-filled text-success me-2"></i>Paid
                            </span>
                            <span class="badge bg-light-success f-w-500">
                                {{ $cotisationsStatus['paid'] ?? 0 }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center">
                                <i class="ti ti-circle-filled text-warning me-2"></i>Pending
                            </span>
                            <span class="badge bg-light-warning f-w-500">
                                {{ $cotisationsStatus['pending'] ?? 0 }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center">
                                <i class="ti ti-circle-filled text-danger me-2"></i>Overdue
                            </span>
                            <span class="badge bg-light-danger f-w-500">
                                {{ $cotisationsStatus['overdue'] ?? 0 }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/plugins/apexcharts.min.js') }}"></script>

    {{-- Financial Performance Chart Script --}}
    <script>
        (function() {
            var options = {
                chart: {
                    type: 'bar',
                    height: 300,
                    stacked: true,
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: { columnWidth: '50%' }
                },
                series: [
                    {
                        name: 'Cotisations',
                        data: {!! json_encode($cashflowData['180']['series'][0]['data'] ?? []) !!}
                    }
                ],
                xaxis: {
                    categories: {!! json_encode($cashflowData['180']['categories'] ?? []) !!}
                },
                yaxis: {
                    labels: {
                        formatter: (val) => `${val.toLocaleString()} MAD`
                    }
                },
                colors: ['var(--bs-success)'],
                dataLabels: { enabled: false },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    markers: { radius: 12 }
                }
            };

            var chart = new ApexCharts(document.querySelector("#financial-performance-chart"), options);
            chart.render();
        })();
    </script>

    {{-- Cotisation Status Chart Script --}}
    <script>
        (function() {
            var options = {
                chart: {
                    type: 'donut',
                    height: 250
                },
                series: [
                    {{ $cotisationsStatus['paid'] ?? 0 }},
                    {{ $cotisationsStatus['pending'] ?? 0 }},
                    {{ $cotisationsStatus['overdue'] ?? 0 }}
                ],
                labels: ['Paid', 'Pending', 'Overdue'],
                colors: ['var(--bs-success)', 'var(--bs-warning)', 'var(--bs-danger)'],
                dataLabels: { enabled: false },
                legend: { show: false }
            };

            var chart = new ApexCharts(document.querySelector("#cotisation-status-chart"), options);
            chart.render();
        })();
    </script>
@endsection
