<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\User;
use App\Models\Cotisation;
use App\Models\Meeting;
use App\Models\MeetingDocument;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // ASSOCIATIONS
        $totalAssociations = Association::count();
        $validatedAssociations = Association::where('is_validated', true)->count();
        $pendingAssociations = Association::where('is_validated', false)->count();

        // USERS
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();

        // COTISATIONS
        $totalCotisations = Cotisation::sum('amount');
        $paidCotisations = Cotisation::where('status', Cotisation::STATUS_PAID)->sum('amount');
        $pendingCotisations = Cotisation::where('status', Cotisation::STATUS_PENDING)->sum('amount');
        $overdueCotisations = Cotisation::where('status', Cotisation::STATUS_OVERDUE)->sum('amount');
        $rejectedCotisations = Cotisation::where('status', Cotisation::STATUS_REJECTED)->sum('amount');

        // MEETINGS
        $totalMeetings = Meeting::count();
        $meetingsThisMonth = Meeting::whereMonth('datetime', $now->month)
                                     ->whereYear('datetime', $now->year)
                                     ->count();
        $upcomingMeetings = Meeting::where('datetime', '>=', $now)->count();
        $completedMeetings = Meeting::where('datetime', '<', $now)->count();

        // MEETING DOCUMENTS
        $uploadedDocuments = MeetingDocument::count();

        // TOP ORGANIZERS (Top 5 by number of meetings)
        $topOrganizers = User::select('users.id', 'users.name', DB::raw('COUNT(meetings.id) as total_meetings'))
            ->join('meetings', 'users.id', '=', 'meetings.organizer_id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_meetings')
            ->limit(5)
            ->get();

        // CASHFLOW (last 6 months only for PAID)
        $cashflow = Cotisation::select(
                DB::raw("DATE_FORMAT(paid_at, '%Y-%m') as month"),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', Cotisation::STATUS_PAID)
            ->whereNotNull('paid_at')
            ->where('paid_at', '>=', $now->copy()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $cashflowLabels = $cashflow->pluck('month');
        $cashflowData = $cashflow->pluck('total');

        // COTISATION DONUT CHART STATUS COUNTS
        $statusCounts = [
            'paid'     => Cotisation::where('status', Cotisation::STATUS_PAID)->count(),
            'pending'  => Cotisation::where('status', Cotisation::STATUS_PENDING)->count(),
            'overdue'  => Cotisation::where('status', Cotisation::STATUS_OVERDUE)->count(),
            'rejected' => Cotisation::where('status', Cotisation::STATUS_REJECTED)->count(),
        ];

        // RETURN ALL DATA TO VIEW
        return view('admin.dashboard', compact(
            'totalAssociations',
            'validatedAssociations',
            'pendingAssociations',
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'totalCotisations',
            'paidCotisations',
            'pendingCotisations',
            'overdueCotisations',
            'rejectedCotisations',
            'totalMeetings',
            'meetingsThisMonth',
            'upcomingMeetings',
            'completedMeetings',
            'uploadedDocuments',
            'topOrganizers',
            'cashflowLabels',
            'cashflowData',
            'statusCounts'
        ));
    }
}
