@extends('layouts.main')

@section('title', 'User Guide')
@section('breadcrumb-item', 'Help')
@section('breadcrumb-item-active', 'User Guide')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex align-items-center justify-content-between">
                <h4 class="mb-0"><i class="ph-duotone ph-compass me-2"></i>Platform User Guide</h4>
            </div>
            <div class="card-body">
                <p class="text-muted">Welcome! This guide will walk you through how to use the platform effectively as a member.</p>

                <!-- Step 1 -->
                <div class="mb-4">
                    <h5><i class="ph-duotone ph-user-plus me-2 text-primary"></i>1. Complete Your Profile</h5>
                    <p>Click on your profile in the top-right corner and choose <strong>"Edit Profile"</strong>. Make sure to fill out all required fields for better participation and visibility.</p>
                </div>

                <!-- Step 2 -->
                <div class="mb-4">
                    <h5><i class="ph-duotone ph-wallet me-2 text-success"></i>2. View & Pay Cotisations</h5>
                    <p>In your dashboard, go to <strong>"My Cotisation Status"</strong> to view your payments. Click "Pay Now" if any dues are pending.</p>
                </div>

                <!-- Step 3 -->
                <div class="mb-4">
                    <h5><i class="ph-duotone ph-calendar-check me-2 text-info"></i>3. Follow Meetings & Events</h5>
                    <p>Check the <strong>"Upcoming Meetings"</strong> section for your next events. You can RSVP or view meeting details from there.</p>
                </div>

                <!-- Step 4 -->
                <div class="mb-4">
                    <h5><i class="ph-duotone ph-chart-bar me-2 text-warning"></i>4. Monitor Your History</h5>
                    <p>Scroll down in your dashboard to view your <strong>Cotisation History</strong>. Use the dropdown to change the timeline view.</p>
                </div>

                <!-- Step 5 -->
                <div class="mb-4">
                    <h5><i class="ph-duotone ph-lifebuoy me-2 text-danger"></i>5. Need Help?</h5>
                    <p>If you encounter any issue, contact your association admin or use the <strong>Helpdesk</strong> to open a support ticket.</p>
                </div>

                <div class="text-end">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="ph ph-arrow-left me-1"></i> Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
