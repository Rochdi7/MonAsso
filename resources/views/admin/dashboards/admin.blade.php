@extends('layouts.main')

@section('title', 'Admin Dashboard')
@section('breadcrumb-item', 'Dashboard')
@section('breadcrumb-item-active', 'Association Management')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/plugins/jsvectormap.min.css') }}">
@endsection

@section('content')
    <div class="row align-items-center mb-3">
        <div class="col-md-8">
            <p class="text-muted mb-0">
                Manage your members, finances, and engagement for
                <strong>{{ $association->name }}</strong>.
            </p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.membres.create') }}" class="btn btn-primary d-inline-flex align-items-center">
                <i class="ti ti-user-plus me-2"></i>Add New Member
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Member Statistics -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-primary"><i class="ti ti-users f-20"></i></div>
                        <h6 class="ms-3 mb-0">Member Statistics</h6>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0">{{ $users['total'] }}</h4>
                        <span class="badge bg-light-primary">Active: {{ $users['active'] }}</span>
                    </div>
                    <div class="text-end mt-1">
                        <span class="badge bg-light-danger">Inactive: {{ $users['inactive'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cotisations -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-success"><i class="ti ti-wallet f-20"></i></div>
                        <h6 class="ms-3 mb-0">Cotisations (YTD)</h6>
                    </div>
                    <h4 class="mt-3 mb-0">
                        {{ number_format($cotisations['total'], 0, '.', ' ') }} MAD
                        <span class="text-success text-sm fw-normal">/ 50,000 MAD Target</span>
                    </h4>
                    @php
                        $target = 50000;
                        $progress =
                            $cotisations['total'] > 0 ? min(round(($cotisations['total'] / $target) * 100, 1), 100) : 0;
                    @endphp
                    <div class="progress mt-2" style="height: 7px">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%"
                            aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meetings -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-info">
                            <i class="ti ti-calendar-event f-20"></i>
                        </div>
                        <h6 class="ms-3 mb-0">Upcoming Meetings</h6>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0">{{ $meetings['upcoming'] }}</h4>
                    </div>
                    <p class="text-sm text-muted mt-1 mb-0">
                        @if ($meetings['upcoming'] > 0)
                            Next meeting scheduled soon
                        @else
                            No upcoming meetings
                        @endif
                    </p>
                </div>

            </div>
        </div>

        <!-- Events -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avtar avtar-s bg-light-warning"><i class="ti ti-ticket f-20"></i></div>
                        <h6 class="ms-3 mb-0">Active Events</h6>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <h4 class="mb-0">{{ $events['active'] }}</h4>
                        <a href="{{ route('admin.events.create') }}"
                            class="btn btn-sm btn-warning d-inline-flex align-items-center">
                            <i class="ti ti-ticket-plus me-1"></i> Create
                        </a>
                    </div>
                    <p class="text-sm text-muted mt-1 mb-0">
                        Total registrations not tracked
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Cashflow Chart -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Monthly Cotisation Collection</h5>
                    <select id="cotisation-range" class="form-select rounded-3 form-select-sm w-auto">
                        <option value="30">Last 30 Days</option>
                        <option value="180" selected>Last 6 Months</option>
                        <option value="365">Yearly</option>
                    </select>
                </div>
                <div class="card-body">
                    <div id="association-cotisations-chart"></div>
                </div>
            </div>

            <!-- Recent Cotisations -->
            <div class="card table-card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Recent Cotisations</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                @forelse($recentCotisations as $cotisation)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avtar avtar-s bg-light-primary">
                                                    <i class="ti ti-user"></i>
                                                </div>
                                                <h6 class="mb-0 ms-3">
                                                    {{ $cotisation->user?->name ?? 'Unknown' }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            Paid cotisation:
                                            <span class="fw-bold">
                                                {{ number_format($cotisation->amount, 2) }} MAD
                                            </span>
                                            @if ($cotisation->status)
                                                <span class="badge bg-light ms-2 text-dark">
                                                    {{ ucfirst($cotisation->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end text-muted">
                                            <small>{{ $cotisation->created_at->diffForHumans() }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            No recent cotisations found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.events.create') }}"
                            class="btn btn-outline-primary d-inline-flex align-items-center justify-content-center">
                            <i class="ti ti-calendar-plus me-2"></i>Create New Event
                        </a>
                        <a href="{{ route('admin.cotisations.create') }}"
                            class="btn btn-outline-success d-inline-flex align-items-center justify-content-center">
                            <i class="ti ti-currency-dollar me-2"></i>New Cotisation
                        </a>
                        <a href="{{ route('admin.contributions.create') }}"
                            class="btn btn-outline-secondary d-inline-flex align-items-center justify-content-center">
                            <i class="ti ti-cash me-2"></i>New Contribution
                        </a>
                    </div>
                </div>
            </div>

            <!-- Cotisation Status Donut -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Cotisation Status</h5>
                </div>
                <div class="card-body">
                    <div id="cotisation-status-donut" class="mt-2"></div>
                    <ul class="list-group list-group-flush mt-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center">
                                <i class="ti ti-circle-filled text-success me-2"></i>Paid
                            </span>
                            <span class="badge bg-light-success f-w-500">{{ $cotisationsStatus['paid'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center">
                                <i class="ti ti-circle-filled text-warning me-2"></i>Pending
                            </span>
                            <span class="badge bg-light-warning f-w-500">{{ $cotisationsStatus['pending'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="p-0 d-inline-flex align-items-center">
                                <i class="ti ti-circle-filled text-danger me-2"></i>Overdue
                            </span>
                            <span class="badge bg-light-danger f-w-500">{{ $cotisationsStatus['overdue'] }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('build/js/plugins/apexcharts.min.js') }}"></script>
    <script>
        new ApexCharts(document.querySelector("#cotisation-status-donut"), {
            chart: {
                type: 'donut',
                height: 200
            },
            series: [
                {{ $cotisationsStatus['paid'] }},
                {{ $cotisationsStatus['pending'] }},
                {{ $cotisationsStatus['overdue'] }}
            ],
            labels: ['Paid', 'Pending', 'Overdue'],
            colors: ['var(--bs-success)', 'var(--bs-warning)', 'var(--bs-danger)'],
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            }
        }).render();

        const cotisationChartData = @json($cashflowData);

        const cotisationChart = new ApexCharts(document.querySelector("#association-cotisations-chart"), {
            chart: {
                type: 'bar',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ['var(--bs-primary)'],
            series: cotisationChartData[180].series,
            xaxis: {
                categories: cotisationChartData[180].categories
            },
            yaxis: {
                labels: {
                    formatter: (val) => `${Number(val).toLocaleString()} MAD`
                }
            }
        });

        cotisationChart.render();

        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('cotisation-range');
            if (select) {
                select.addEventListener('change', function() {
                    const selected = this.value;
                    cotisationChart.updateOptions({
                        series: cotisationChartData[selected].series,
                        xaxis: {
                            categories: cotisationChartData[selected].categories
                        }
                    });
                });
            }
        });
    </script>
@endsection
