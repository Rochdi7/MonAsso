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
                        <h4 class="mb-0">1,247</h4>
                        {{-- UPDATED: Used a badge for a cleaner look --}}
                        <span class="badge bg-light-primary">Active: 1,105</span>
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
                        <h4 class="mb-0">72%</h4>
                        {{-- This badge style is already perfect for the theme --}}
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
                        <h4 class="mb-0">$84,550</h4>
                        {{-- UPDATED: Used a badge for consistency --}}
                        <span class="badge bg-light-secondary">Target: $100k</span>
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
                        <h4 class="mb-0">4</h4>
                        {{-- UPDATED: Used a badge for consistency --}}
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
                                    <th>Meeting Title</th> <th>Date</th> <th>Attendees</th> <th>Participation Rate</th> <th class="text-end">View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Annual General Meeting 2024</td>
                                    <td>Feb 20, 2024</td>
                                    <td>980 / 1247</td>
                                    <td><span class="text-success">78.5%</span></td>
                                    <td class="text-end">
                                        {{-- UPDATED: Used theme-consistent icon button --}}
                                        <a href="#" class="btn btn-icon btn-light-secondary"><i class="ti ti-eye"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Q1 Budget Review</td>
                                    <td>Jan 15, 2024</td>
                                    <td>850 / 1247</td>
                                    <td><span class="text-warning">68.1%</span></td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-icon btn-light-secondary"><i class="ti ti-eye"></i></a>
                                    </td>
                                </tr>
                                 <tr>
                                    <td>Strategic Planning Session</td>
                                    <td>Dec 05, 2023</td>
                                    <td>910 / 1247</td>
                                    <td><span class="text-success">73.0%</span></td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-icon btn-light-secondary"><i class="ti ti-eye"></i></a>
                                    </td>
                                </tr>
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
                            <span class="p-0 d-inline-flex align-items-center"><i class="ti ti-circle-filled text-success me-2"></i>Paid</span>
                            <span class="badge bg-light-success f-w-500">85%</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                             <span class="p-0 d-inline-flex align-items-center"><i class="ti ti-circle-filled text-warning me-2"></i>Pending</span>
                            <span class="badge bg-light-warning f-w-500">10%</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center"><i class="ti ti-circle-filled text-danger me-2"></i>Overdue</span>
                            <span class="badge bg-light-danger f-w-500">5%</span>
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
                chart: { type: 'bar', height: 300, stacked: true, toolbar: { show: false } },
                plotOptions: { bar: { columnWidth: '50%' } },
                series: [{
                    name: 'Cotisations',
                    data: [18000, 25000, 32000, 28000, 35000, 40000]
                }, {
                    name: 'Expenses',
                    data: [-12000, -15000, -10000, -18000, -22000, -19000]
                }],
                xaxis: { categories: ['Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'] },
                yaxis: { labels: { formatter: (val) => { return `$${val/1000}k` } } },
                // UPDATED: Replaced hardcoded colors with Bootstrap CSS variables
                colors: ['var(--bs-success)', 'var(--bs-danger)'],
                dataLabels: { enabled: false },
                legend: { position: 'top', horizontalAlign: 'right', markers: { radius: 12 } }
            };
            var chart = new ApexCharts(document.querySelector("#financial-performance-chart"), options);
            chart.render();
        })();
    </script>

    {{-- Cotisation Status Chart Script --}}
    <script>
        (function() {
            var options = {
                chart: { type: 'donut', height: 250 },
                series: [85, 10, 5], // Static data: Paid, Pending, Overdue
                labels: ['Paid', 'Pending', 'Overdue'],
                // UPDATED: Replaced hardcoded colors with Bootstrap CSS variables
                colors: ['var(--bs-success)', 'var(--bs-warning)', 'var(--bs-danger)'],
                dataLabels: { enabled: false },
                legend: { show: false },
            };
            var chart = new ApexCharts(document.querySelector("#cotisation-status-chart"), options);
            chart.render();
        })();
    </script>
@endsection