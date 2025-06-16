@extends('layouts.main')

@section('title', 'Complete Statistics')
@section('breadcrumb-item', 'Dashboard')
@section('breadcrumb-item-active', 'Complete Statistics')

@section('content')

<!-- ========================================================================================= -->
<!-- Top-Level Dashboard Row -->
<!-- ========================================================================================= -->
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Monthly Cotisations</h5></div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-1">
                    <h3 class="mb-0">$1,250.75 <small class="text-muted">/ this month</small></h3>
                    <span class="badge bg-light-success ms-2">+12%</span>
                </div>
                <p>Total amount collected from paid cotisations.</p>
                <!-- Chart ID from template -->
                <div id="customer-rate-graph"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Member Activity</h5></div>
            <div class="card-body">
                <p class="mb-0">New members this week</p>
                <h4>24</h4>
                <!-- Chart ID from template -->
                <div id="monthly-report-graph"></div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================================= -->
<!-- NEW SECTION: Association & Member Performance -->
<!-- ========================================================================================= -->
<div class="row">
    <div class="col-12">
        <h4 class="mt-4 mb-3">Performance & Activity</h4>
    </div>

    <!-- Association Breakdown -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5>Association Breakdown</h5></div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr><th>Association Name</th><th>Members</th><th>Meetings</th><th>Cotisations Paid</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Alpha Innovators Club</td>
                            <td>152</td>
                            <td>12</td>
                            <td class="text-success">$8,450.00</td>
                        </tr>
                        <tr>
                            <td>Beta Tech Group</td>
                            <td>88</td>
                            <td>5</td>
                            <td class="text-success">$4,200.50</td>
                        </tr>
                        <tr>
                            <td>Gamma Community Network</td>
                            <td>210</td>
                            <td>25</td>
                            <td class="text-success">$11,750.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top Paying Members -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><h5>Top Paying Members</h5></div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">John Doe<span class="badge bg-success rounded-pill">$550</span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Jane Smith<span class="badge bg-success rounded-pill">$525</span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Sam Wilson<span class="badge bg-success rounded-pill">$500</span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Maria Garcia<span class="badge bg-success rounded-pill">$480</span></li>
                <li class="list-group-item d-flex justify-content-between align-items-center">Peter Jones<span class="badge bg-success rounded-pill">$475</span></li>
            </ul>
        </div>
    </div>
</div>

<!-- ========================================================================================= -->
<!-- NEW SECTION: Member Retention & Financial Overview -->
<!-- ========================================================================================= -->
<div class="row">
     <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><h5>Member Retention (Active vs. Inactive)</h5></div>
            <div class="card-body">
                <!-- Using reports-chart for this as it's a nice big line chart -->
                <div id="reports-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5>Financial Overview (Yearly)</h5>
            </div>
            <div class="card-body">
                <div class="row justify-content-center g-3 text-center mb-3">
                    <div class="col-6 col-md-4">
                        <div class="overview-product-legends">
                            <p class="text-muted mb-1"><span>Cotisations Due</span></p>
                            <h4 class="mb-0">$15,400</h4>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="overview-product-legends">
                            <p class="text-muted mb-1"><span>Collected</span></p>
                            <h4 class="mb-0 text-success">$12,850</h4>
                        </div>
                    </div>
                     <div class="col-6 col-md-4">
                        <div class="overview-product-legends">
                            <p class="text-muted mb-1"><span>Overdue</span></p>
                            <h4 class="mb-0 text-danger">$2,550</h4>
                        </div>
                    </div>
                </div>
                 <!-- Chart ID from template -->
                <div id="yearly-summary-chart"></div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================================= -->
<!-- NEW SECTION: System & Financial Health Cards -->
<!-- ========================================================================================= -->
<div class="row">
    <div class="col-12">
        <h4 class="mt-4 mb-3">System & Financial Health</h4>
    </div>

    <!-- Upcoming Meetings Preview -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><h5>Upcoming Meetings</h5></div>
             <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="d-flex w-100 justify-content-between"><h6 class="mb-1">Q4 Financial Review</h6><small>Oct 28</small></div>
                    <p class="mb-1 text-muted">Organizer: Admin User</p>
                </li>
                <li class="list-group-item">
                    <div class="d-flex w-100 justify-content-between"><h6 class="mb-1">Annual General Meeting</h6><small>Nov 15</small></div>
                    <p class="mb-1 text-muted">Organizer: Jane Smith</p>
                </li>
            </ul>
        </div>
    </div>

    <!-- Payment Success Rate -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><h5>Payment Success Rate</h5></div>
            <div class="card-body text-center">
                 <!-- Using project-rating-chart as it's a radial bar chart -->
                 <div id="project-rating-chart" style="min-height: 165px;"></div>
                 <p class="text-muted">Failed payments this month: <b>8</b></p>
            </div>
        </div>
    </div>

    <!-- File Storage Usage -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><h5>File Storage Usage</h5></div>
            <div class="card-body">
                <h5>4.25 GB <small class="text-muted"> / 10 GB</small></h5>
                <div class="progress mt-3" style="height: 10px;">
                  <div class="progress-bar" role="progressbar" style="width: 42.5%;" aria-valuenow="42.5" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="text-muted mt-2">SaaS Plan Storage Limit</p>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================================= -->
<!-- NEW SECTION: Admin & Advanced Reports -->
<!-- ========================================================================================= -->
<div class="row">
    <div class="col-12">
        <h4 class="mt-4 mb-3">Admin & Advanced Reports</h4>
    </div>
    
    <!-- Cotisation Type History -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5>Cotisation by Type (Last 6 Months)</h5></div>
            <div class="card-body">
                <!-- Using overview-bar-chart as a placeholder -->
                <div id="overview-bar-chart" style="min-height: 250px;"></div>
            </div>
        </div>
    </div>
    
    <!-- Admin Activity Logs -->
    <div class="col-lg-4">
         <div class="card">
            <div class="card-header"><h5>Admin Performance</h5></div>
             <div class="card-body table-responsive p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Admin Name</th><th>Meetings Org.</th><th>Assocs. Valid.</th></tr></thead>
                    <tbody>
                        <tr><td>Admin User</td><td>22</td><td>8</td></tr>
                        <tr><td>Support Staff</td><td>8</td><td>12</td></tr>
                        <tr><td>Jane Doe</td><td>15</td><td>18</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- Apex Chart -->
<script src="{{ URL::asset('build/js/plugins/apexcharts.min.js') }}"></script>

<!-- Using ALL static chart widgets from your template -->
<script src="{{ URL::asset('build/js/widgets/customer-rate-graph.js') }}"></script> 
<script src="{{ URL::asset('build/js/widgets/monthly-report-graph.js') }}"></script> 
<script src="{{ URL::asset('build/js/widgets/yearly-summary-chart.js') }}"></script> 
<script src="{{ URL::asset('build/js/widgets/overview-chart-1-2.js') }}"></script> 
<script src="{{ URL::asset('build/js/widgets/transactions-chart.js') }}"></script>
<script src="{{ URL::asset('build/js/widgets/canceled-order-chart.js') }}"></script>
<script src="{{ URL::asset('build/js/widgets/total-order-chart.js') }}"></script>
<script src="{{ URL::asset('build/js/widgets/project-rating-chart.js') }}"></script>
<script src="{{ URL::asset('build/js/widgets/reports-chart.js') }}"></script>
<script src="{{ URL::asset('build/js/widgets/overview-bar-chart.js') }}"></script>
<!-- You can add more scripts from your template here if needed -->

@endsection