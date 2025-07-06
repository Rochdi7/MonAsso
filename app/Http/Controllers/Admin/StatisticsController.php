<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\User;
use App\Models\Cotisation;
use App\Models\Meeting;
use App\Models\Event;
use App\Models\Contribution;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        $auth = auth()->user();

        if ($auth->hasRole('superadmin')) {
            $data = $this->getSuperAdminStatisticsData();
            return view('admin.statistics.superadmin', $data);
        }

        if ($auth->hasRole('admin')) {
            $data = $this->getAdminStatisticsData();
            return view('admin.statistics.admin', $data);
        }

        if ($auth->hasRole('board')) {
            $data = $this->getBoardStatisticsData();
            return view('admin.statistics.board', $data);
        }

        if ($auth->hasRole('supervisor')) {
            $data = $this->getSupervisorStatisticsData();
            return view('admin.statistics.supervisor', $data);
        }

        if ($auth->hasRole('member')) {
            $data = $this->getMemberStatisticsData();
            return view('admin.statistics.member', $data);
        }

        abort(403, 'Unauthorized access.');
    }

    /**
     * Super Admin statistics data.
     */
    protected function getSuperAdminStatisticsData(): array
    {
        $base = $this->buildStatisticsBaseData();

        $totalAssociations = Association::count();
        $pendingAssociations = Association::where('is_validated', false)->count();

        $base['superadminDetails'] = [
            'totalAssociations' => $totalAssociations,
            'pendingAssociations' => $pendingAssociations,
        ];

        return $base;
    }

    /**
     * Admin statistics data.
     */
    protected function getAdminStatisticsData(): array
    {
        $auth = auth()->user();
        $associationId = $auth->association_id;
        $now = Carbon::now();

        // Members
        $totalActiveMembers = User::where('association_id', $associationId)
            ->where('is_active', true)
            ->count();

        $totalInactiveMembers = User::where('association_id', $associationId)
            ->where('is_active', false)
            ->count();

        $totalMembers = $totalActiveMembers + $totalInactiveMembers;

        // Cotisations
        $cotisationsPaidMAD = Cotisation::where('association_id', $associationId)
            ->where('status', Cotisation::STATUS_PAID)
            ->sum('amount');

        $cotisationsPendingMAD = Cotisation::where('association_id', $associationId)
            ->where('status', Cotisation::STATUS_PENDING)
            ->sum('amount');

        $cotisationsOverdueRejectedMAD = Cotisation::where('association_id', $associationId)
            ->whereIn('status', [
                Cotisation::STATUS_OVERDUE,
                Cotisation::STATUS_REJECTED
            ])
            ->sum('amount');

        // Inflow/Outflow
        $totalInflowMAD = Contribution::where('association_id', $associationId)->sum('amount');
        $totalOutflowMAD = Expense::where('association_id', $associationId)->sum('amount');

        // Member growth chart
        $memberGrowthChartData = $this->buildMemberGrowthChart($associationId);

        // Cashflow
        $cashflowDataQuery = Cotisation::select(
            DB::raw('SUM(amount) as total'),
            DB::raw("DATE_FORMAT(paid_at, '%b') as month")
        )
            ->where('association_id', $associationId)
            ->where('status', Cotisation::STATUS_PAID)
            ->where('paid_at', '>=', $now->copy()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderByRaw("MIN(paid_at) ASC")
            ->get();

        $cashflowLabels = $cashflowDataQuery->pluck('month');
        $cashflowValues = $cashflowDataQuery->pluck('total');

        // New users chart
        $newUsersDataQuery = User::select(
            DB::raw('COUNT(id) as count'),
            DB::raw("DATE_FORMAT(created_at, '%b') as month")
        )
            ->where('association_id', $associationId)
            ->where('created_at', '>=', $now->copy()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderByRaw("MIN(created_at) ASC")
            ->get();

        $newUserLabels = $newUsersDataQuery->pluck('month');
        $newUserValues = $newUsersDataQuery->pluck('count');

        // Cotisation status breakdown
        $statusCounts = [
            'paid' => Cotisation::where('association_id', $associationId)
                ->where('status', Cotisation::STATUS_PAID)
                ->count(),
            'pending' => Cotisation::where('association_id', $associationId)
                ->where('status', Cotisation::STATUS_PENDING)
                ->count(),
            'overdue' => Cotisation::where('association_id', $associationId)
                ->where('status', Cotisation::STATUS_OVERDUE)
                ->count(),
            'rejected' => Cotisation::where('association_id', $associationId)
                ->where('status', Cotisation::STATUS_REJECTED)
                ->count(),
        ];

        return [
            'totalActiveMembers' => $totalActiveMembers,
            'totalInactiveMembers' => $totalInactiveMembers,
            'totalMembers' => $totalMembers,
            'cotisationsPaidMAD' => $cotisationsPaidMAD,
            'cotisationsPendingMAD' => $cotisationsPendingMAD,
            'cotisationsOverdueRejectedMAD' => $cotisationsOverdueRejectedMAD,
            'totalInflowMAD' => $totalInflowMAD,
            'totalOutflowMAD' => $totalOutflowMAD,
            'memberGrowthChartData' => $memberGrowthChartData,
            'cashflowLabels' => $cashflowLabels,
            'cashflowValues' => $cashflowValues,
            'newUserLabels' => $newUserLabels,
            'newUserValues' => $newUserValues,
            'statusCounts' => $statusCounts,
        ];
    }

    /**
     * Board statistics data.
     */
    protected function getBoardStatisticsData(): array
    {
        $auth = auth()->user();
        $associationId = $auth->association_id;
        $now = Carbon::now();

        // Members
        $totalActiveMembers = User::where('association_id', $associationId)
            ->where('is_active', true)
            ->count();

        $totalInactiveMembers = User::where('association_id', $associationId)
            ->where('is_active', false)
            ->count();

        $totalMembers = $totalActiveMembers + $totalInactiveMembers;

        // Cotisations
        $cotisationsPaidMAD = Cotisation::where('association_id', $associationId)
            ->where('status', Cotisation::STATUS_PAID)
            ->sum('amount');

        $cotisationsPendingMAD = Cotisation::where('association_id', $associationId)
            ->where('status', Cotisation::STATUS_PENDING)
            ->sum('amount');

        $cotisationsOverdueRejectedMAD = Cotisation::where('association_id', $associationId)
            ->whereIn('status', [
                Cotisation::STATUS_OVERDUE,
                Cotisation::STATUS_REJECTED
            ])
            ->sum('amount');

        // Inflow/Outflow
        $totalInflowMAD = Contribution::where('association_id', $associationId)->sum('amount');
        $totalOutflowMAD = Expense::where('association_id', $associationId)->sum('amount');

        // Member growth chart
        $memberGrowthChartData = $this->buildMemberGrowthChart($associationId);

        // Cashflow
        $cashflowDataQuery = Cotisation::select(
            DB::raw('SUM(amount) as total'),
            DB::raw("DATE_FORMAT(paid_at, '%b') as month")
        )
            ->where('association_id', $associationId)
            ->where('status', Cotisation::STATUS_PAID)
            ->where('paid_at', '>=', $now->copy()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderByRaw("MIN(paid_at) ASC")
            ->get();

        $cashflowLabels = $cashflowDataQuery->pluck('month');
        $cashflowValues = $cashflowDataQuery->pluck('total');

        // New users chart
        $newUsersDataQuery = User::select(
            DB::raw('COUNT(id) as count'),
            DB::raw("DATE_FORMAT(created_at, '%b') as month")
        )
            ->where('association_id', $associationId)
            ->where('created_at', '>=', $now->copy()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderByRaw("MIN(created_at) ASC")
            ->get();

        $newUserLabels = $newUsersDataQuery->pluck('month');
        $newUserValues = $newUsersDataQuery->pluck('count');

        // Cotisation status breakdown
        $statusCounts = [
            'paid' => Cotisation::where('association_id', $associationId)
                ->where('status', Cotisation::STATUS_PAID)
                ->count(),
            'pending' => Cotisation::where('association_id', $associationId)
                ->where('status', Cotisation::STATUS_PENDING)
                ->count(),
            'overdue' => Cotisation::where('association_id', $associationId)
                ->where('status', Cotisation::STATUS_OVERDUE)
                ->count(),
            'rejected' => Cotisation::where('association_id', $associationId)
                ->where('status', Cotisation::STATUS_REJECTED)
                ->count(),
        ];

        return [
            'totalActiveMembers' => $totalActiveMembers,
            'totalInactiveMembers' => $totalInactiveMembers,
            'totalMembers' => $totalMembers,
            'cotisationsPaidMAD' => $cotisationsPaidMAD,
            'cotisationsPendingMAD' => $cotisationsPendingMAD,
            'cotisationsOverdueRejectedMAD' => $cotisationsOverdueRejectedMAD,
            'totalInflowMAD' => $totalInflowMAD,
            'totalOutflowMAD' => $totalOutflowMAD,
            'memberGrowthChartData' => $memberGrowthChartData,
            'cashflowLabels' => $cashflowLabels,
            'cashflowValues' => $cashflowValues,
            'newUserLabels' => $newUserLabels,
            'newUserValues' => $newUserValues,
            'statusCounts' => $statusCounts,
        ];
    }


    /**
     * Supervisor statistics data.
     */
    protected function getSupervisorStatisticsData(): array
    {
        $auth = auth()->user();
        $associationId = $auth->association_id;
        $now = Carbon::now();

        // Members
        $totalActiveMembers = User::where('association_id', $associationId)
            ->where('is_active', true)
            ->count();

        $totalInactiveMembers = User::where('association_id', $associationId)
            ->where('is_active', false)
            ->count();

        $totalMembers = $totalActiveMembers + $totalInactiveMembers;

        // Cotisations
        $cotisationsPaidMAD = Cotisation::where('association_id', $associationId)
            ->where('status', Cotisation::STATUS_PAID)
            ->sum('amount');

        $cotisationsPendingMAD = Cotisation::where('association_id', $associationId)
            ->where('status', Cotisation::STATUS_PENDING)
            ->sum('amount');

        $cotisationsOverdueRejectedMAD = Cotisation::where('association_id', $associationId)
            ->whereIn('status', [
                Cotisation::STATUS_OVERDUE,
                Cotisation::STATUS_REJECTED
            ])
            ->sum('amount');

        // Inflow/Outflow
        $totalInflowMAD = Contribution::where('association_id', $associationId)->sum('amount');
        $totalOutflowMAD = Expense::where('association_id', $associationId)->sum('amount');

        // Member growth chart
        $memberGrowthChartData = $this->buildMemberGrowthChart($associationId);

        // Cashflow
        $cashflowDataQuery = Cotisation::select(
            DB::raw('SUM(amount) as total'),
            DB::raw("DATE_FORMAT(paid_at, '%b') as month")
        )
            ->where('association_id', $associationId)
            ->where('status', Cotisation::STATUS_PAID)
            ->where('paid_at', '>=', $now->copy()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderByRaw("MIN(paid_at) ASC")
            ->get();

        $cashflowLabels = $cashflowDataQuery->pluck('month');
        $cashflowValues = $cashflowDataQuery->pluck('total');

        // New users chart
        $newUsersDataQuery = User::select(
            DB::raw('COUNT(id) as count'),
            DB::raw("DATE_FORMAT(created_at, '%b') as month")
        )
            ->where('association_id', $associationId)
            ->where('created_at', '>=', $now->copy()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderByRaw("MIN(created_at) ASC")
            ->get();

        $newUserLabels = $newUsersDataQuery->pluck('month');
        $newUserValues = $newUsersDataQuery->pluck('count');

        // Cotisation status breakdown
        $statusCounts = [
            'paid' => Cotisation::where('association_id', $associationId)
                ->where('status', Cotisation::STATUS_PAID)
                ->count(),
            'pending' => Cotisation::where('association_id', $associationId)
                ->where('status', Cotisation::STATUS_PENDING)
                ->count(),
            'overdue' => Cotisation::where('association_id', $associationId)
                ->where('status', Cotisation::STATUS_OVERDUE)
                ->count(),
            'rejected' => Cotisation::where('association_id', $associationId)
                ->where('status', Cotisation::STATUS_REJECTED)
                ->count(),
        ];

        // Active events
        $activeEvents = Event::where('association_id', $associationId)
            ->where('status', 1)
            ->count();

        return [
            'totalActiveMembers' => $totalActiveMembers,
            'totalInactiveMembers' => $totalInactiveMembers,
            'totalMembers' => $totalMembers,
            'cotisationsPaidMAD' => $cotisationsPaidMAD,
            'cotisationsPendingMAD' => $cotisationsPendingMAD,
            'cotisationsOverdueRejectedMAD' => $cotisationsOverdueRejectedMAD,
            'totalInflowMAD' => $totalInflowMAD,
            'totalOutflowMAD' => $totalOutflowMAD,
            'memberGrowthChartData' => $memberGrowthChartData,
            'cashflowLabels' => $cashflowLabels,
            'cashflowValues' => $cashflowValues,
            'newUserLabels' => $newUserLabels,
            'newUserValues' => $newUserValues,
            'statusCounts' => $statusCounts,
            'activeEvents' => $activeEvents,
        ];
    }


    /**
     * Member statistics data.
     */
    protected function getMemberStatisticsData(): array
    {
        $auth = auth()->user();

        // Dummy cotisations
        $myCotisationsList = collect([
            (object)[
                'cycle' => '2024 Annual',
                'amount' => 1200,
                'due_date' => now()->addDays(15)->format('Y-m-d'),
                'status' => 'pending',
            ],
            (object)[
                'cycle' => '2023 Annual',
                'amount' => 1200,
                'due_date' => now()->subMonths(2)->format('Y-m-d'),
                'status' => 'paid',
            ],
        ]);

        $paidTotal = 2400;
        $pendingTotal = 1200;
        $overdueTotal = 0;

        $cashflowLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        $cashflowValues = [300, 200, 250, 100, 500, 400];

        // ✅ New dummy data for meetings & events
        $upcomingMeetingsEvents = collect([
            [
                'title' => 'Quarterly Review',
                'date' => now()->addDays(7)->format('M d, Y'),
                'location' => 'Main Hall',
                'time_diff' => 'in 7 days',
                'link' => route('admin.meetings.index'),
            ],
            [
                'title' => 'Annual Charity Gala',
                'date' => now()->addDays(15)->format('M d, Y'),
                'location' => 'Conference Center',
                'time_diff' => 'in 15 days',
                'link' => route('membre.events.index'),
            ],
        ]);

        $recentActivities = collect([
            (object)[
                'date' => now()->subDays(2)->format('Y-m-d'),
                'type' => 'Paid Cotisation',
                'details' => 'Annual Dues 2024',
            ],
            (object)[
                'date' => now()->subDays(5)->format('Y-m-d'),
                'type' => 'Joined Event',
                'details' => 'Community Workshop',
            ],
        ]);

        return [
            'user' => $auth,
            'myCotisationsList' => $myCotisationsList,
            'paidTotal' => $paidTotal,
            'pendingTotal' => $pendingTotal,
            'overdueTotal' => $overdueTotal,
            'cashflowLabels' => $cashflowLabels,
            'cashflowValues' => $cashflowValues,
            'upcomingMeetingsEvents' => $upcomingMeetingsEvents,
            'recentActivities' => $recentActivities,
        ];
    }


    /**
     * Shared statistics data builder for all roles.
     */
    protected function buildStatisticsBaseData(): array
    {
        $now = Carbon::now();

        $totalActiveMembers = User::where('is_active', true)->count();
        $memberGrowthThisYear = 1240;

        $cotisationsPaidMAD = Cotisation::where('status', Cotisation::STATUS_PAID)->sum('amount');
        $cotisationsPendingMAD = Cotisation::where('status', Cotisation::STATUS_PENDING)->sum('amount');
        $cotisationsOverdueRejectedMAD =
            Cotisation::where('status', Cotisation::STATUS_OVERDUE)->sum('amount') +
            Cotisation::where('status', Cotisation::STATUS_REJECTED)->sum('amount');

        $associationsTotal = Association::where('is_validated', true)->count();
        $associationsGrowthThisYear = 8;

        $totalInflowMAD = Contribution::sum('amount');
        $totalOutflowMAD = Expense::sum('amount');

        $memberGrowthChartData = [
            3 => [
                'categories' => ['Apr', 'May', 'Jun'],
                'data' => [110, 140, 130],
            ],
            6 => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'data' => [95, 120, 150, 110, 140, 130],
            ],
            12 => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'data' => [95, 120, 150, 110, 140, 130, 155, 165, 170, 180, 190, 200],
            ],
        ];

        $cashflowDataQuery = Cotisation::select(
            DB::raw('SUM(amount) as total'),
            DB::raw("DATE_FORMAT(paid_at, '%b') as month")
        )
            ->where('status', Cotisation::STATUS_PAID)
            ->where('paid_at', '>=', $now->copy()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderByRaw("MIN(paid_at) ASC")
            ->get();

        $cashflowLabels = $cashflowDataQuery->pluck('month');
        $cashflowValues = $cashflowDataQuery->pluck('total');

        $newUsersDataQuery = User::select(
            DB::raw('COUNT(id) as count'),
            DB::raw("DATE_FORMAT(created_at, '%b') as month")
        )
            ->where('created_at', '>=', $now->copy()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderByRaw("MIN(created_at) ASC")
            ->get();

        $newUserLabels = $newUsersDataQuery->pluck('month');
        $newUserValues = $newUsersDataQuery->pluck('count');

        $statusCounts = [
            'paid' => Cotisation::where('status', Cotisation::STATUS_PAID)->count(),
            'pending' => Cotisation::where('status', Cotisation::STATUS_PENDING)->count(),
            'overdue' => Cotisation::where('status', Cotisation::STATUS_OVERDUE)->count(),
            'rejected' => Cotisation::where('status', Cotisation::STATUS_REJECTED)->count(),
        ];

        return compact(
            'totalActiveMembers',
            'memberGrowthThisYear',
            'cotisationsPaidMAD',
            'cotisationsPendingMAD',
            'cotisationsOverdueRejectedMAD',
            'associationsTotal',
            'associationsGrowthThisYear',
            'totalInflowMAD',
            'totalOutflowMAD',
            'memberGrowthChartData',
            'cashflowLabels',
            'cashflowValues',
            'newUserLabels',
            'newUserValues',
            'statusCounts'
        );
    }

    /**
     * Helper to build member growth chart for specific association.
     */
    protected function buildMemberGrowthChart($associationId): array
    {
        // Example fake data for chart
        return [
            3 => [
                'categories' => ['Apr', 'May', 'Jun'],
                'data' => [45, 65, 62],
            ],
            6 => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'data' => [20, 35, 50, 45, 65, 62],
            ],
            12 => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'data' => [20, 35, 50, 45, 65, 62, 70, 72, 75, 80, 82, 85],
            ],
        ];
    }
}
