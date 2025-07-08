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

        $upcomingMeetings = [
        [
            'title' => 'Quarterly Review',
            'date' => 'Thu, Apr 18, 2024 - 06:00 PM',
            'location' => 'Main Office',
            'time_diff' => Carbon::parse('2024-04-18 18:00')->diffForHumans(),
            'link' => route('admin.meetings.index'),
        ],
    ];

    $upcomingEvents = [
        [
            'title' => 'Annual Charity Gala',
            'date' => 'Sat, Jun 15, 2024',
            'location' => 'Grand Ballroom',
            'time_diff' => Carbon::parse('2024-06-15')->diffForHumans(),
            'link' => route('membre.events.index'),
        ],
    ];

        abort(403, 'Unauthorized access.');
    }

    /**
     * Super Admin statistics data.
     */
    protected function getSuperAdminStatisticsData(): array
    {
        // Total active members
        $totalActiveMembers = \App\Models\User::role('member')
            ->where('is_active', true)
            ->count();

        // New members registered this year
        $memberGrowthThisYear = \App\Models\User::role('member')
            ->whereYear('created_at', now()->year)
            ->count();

        // Generate chart data
        $memberGrowthChartData = $this->generateMemberGrowthData();

        // Cotisations
        $cotisationsPaidMAD = \App\Models\Cotisation::where('status', 1)->sum('amount');
        $cotisationsPendingMAD = \App\Models\Cotisation::where('status', 0)->sum('amount');
        $cotisationsOverdueRejectedMAD = \App\Models\Cotisation::whereIn('status', [2, 3])->sum('amount');

        // Contributions & expenses
        $totalInflowMAD = \App\Models\Contribution::sum('amount');
        $totalOutflowMAD = \App\Models\Expense::sum('amount');

        // Associations
        $associationsTotal = \App\Models\Association::where('is_validated', true)->count();
        $associationsGrowthThisYear = \App\Models\Association::where('is_validated', true)
            ->whereYear('validation_date', now()->year)
            ->count();

        // Cotisations grouped by association
        $cotisationsByAssociation = \App\Models\Cotisation::select([
            'associations.name as association',
            \DB::raw('SUM(cotisations.amount) as total')
        ])
            ->join('associations', 'cotisations.association_id', '=', 'associations.id')
            ->groupBy('associations.id', 'associations.name')
            ->orderBy('associations.name')
            ->get();

        // Users by roles
        $rolesCounts = [
            'member' => \App\Models\User::role('member')->count(),
            'admin' => \App\Models\User::role('admin')->count(),
            'board' => \App\Models\User::role('board')->count(),
            'superadmin' => \App\Models\User::role('superadmin')->count(),
        ];

        return [
            'totalActiveMembers' => $totalActiveMembers,
            'memberGrowthThisYear' => $memberGrowthThisYear,
            'memberGrowthChartData' => $memberGrowthChartData,
            'cotisationsPaidMAD' => $cotisationsPaidMAD,
            'cotisationsPendingMAD' => $cotisationsPendingMAD,
            'cotisationsOverdueRejectedMAD' => $cotisationsOverdueRejectedMAD,
            'totalInflowMAD' => $totalInflowMAD,
            'totalOutflowMAD' => $totalOutflowMAD,
            'associationsTotal' => $associationsTotal,
            'associationsGrowthThisYear' => $associationsGrowthThisYear,
            'cotisationsByAssociation' => $cotisationsByAssociation,
            'rolesCounts' => $rolesCounts,
        ];
    }

    private function generateMemberGrowthData()
    {
        $data = [];

        foreach ([3, 6, 12] as $months) {
            $labels = [];
            $values = [];

            for ($i = $months - 1; $i >= 0; $i--) {
                $monthStart = now()->startOfMonth()->subMonths($i);
                $monthEnd = $monthStart->copy()->endOfMonth();

                $count = \App\Models\User::role('member')
                    ->where('is_active', true)
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->count();

                $labels[] = $monthStart->format('M Y');
                $values[] = $count;
            }

            $data[$months] = [
                'categories' => $labels,
                'data' => $values,
            ];
        }

        return $data;
    }

    /**
     * Admin statistics data.
     */
    protected function getAdminStatisticsData(): array
    {
        $auth = auth()->user();

        $associationId = $auth->association_id;

        // Total members in this admin's association
        $totalMembers = \App\Models\User::where('association_id', $associationId)
            ->where('is_active', true)
            ->count();

        // Member growth this year
        $memberGrowthThisYear = \App\Models\User::where('association_id', $associationId)
            ->whereYear('created_at', now()->year)
            ->count();

        // Member growth chart data
        $memberGrowthChartData = $this->generateAdminMemberGrowthData($associationId);

        // Cotisations sums
        $cotisationsPaidMAD = \App\Models\Cotisation::where('association_id', $associationId)
            ->where('status', 1)
            ->sum('amount');

        $cotisationsPendingMAD = \App\Models\Cotisation::where('association_id', $associationId)
            ->where('status', 0)
            ->sum('amount');

        $cotisationsOverdueRejectedMAD = \App\Models\Cotisation::where('association_id', $associationId)
            ->whereIn('status', [2, 3])
            ->sum('amount');

        // Cotisation cashflow last 6 months
        $months = 6;
        $cashflowLabels = [];
        $cashflowValues = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $monthStart = now()->startOfMonth()->subMonths($i);
            $monthEnd = $monthStart->copy()->endOfMonth();

            $sum = \App\Models\Cotisation::where('association_id', $associationId)
                ->where('status', 1)
                ->whereBetween('paid_at', [$monthStart, $monthEnd])
                ->sum('amount');

            $cashflowLabels[] = $monthStart->format('M Y');
            $cashflowValues[] = $sum;
        }

        // Monthly expenses (last 6 months)
        $totalOutflowMAD = \App\Models\Expense::where('association_id', $associationId)
            ->whereBetween('spent_at', [
                now()->subMonths(6)->startOfMonth(),
                now()->endOfMonth()
            ])
            ->sum('amount');

        // Contributions (this year)
        $totalInflowMAD = \App\Models\Contribution::where('association_id', $associationId)
            ->whereYear('received_at', now()->year)
            ->sum('amount');

        return [
            'totalMembers' => $totalMembers,
            'memberGrowthThisYear' => $memberGrowthThisYear,
            'memberGrowthChartData' => $memberGrowthChartData,
            'cotisationsPaidMAD' => $cotisationsPaidMAD,
            'cotisationsPendingMAD' => $cotisationsPendingMAD,
            'cotisationsOverdueRejectedMAD' => $cotisationsOverdueRejectedMAD,
            'cashflowLabels' => $cashflowLabels,
            'cashflowValues' => collect($cashflowValues),
            'totalOutflowMAD' => $totalOutflowMAD,
            'totalInflowMAD' => $totalInflowMAD,
        ];
    }

    protected function generateAdminMemberGrowthData(int $associationId): array
    {
        $data = [];

        foreach ([6, 12, 'all'] as $range) {
            $labels = [];
            $values = [];

            if ($range === 'all') {
                $firstMember = \App\Models\User::where('association_id', $associationId)
                    ->orderBy('created_at')
                    ->first();

                $start = $firstMember
                    ? $firstMember->created_at->copy()->startOfMonth()
                    : now()->startOfMonth();

                $end = now()->startOfMonth();

                $monthsDiff = $start->diffInMonths($end) + 1;

                for ($i = 0; $i < $monthsDiff; $i++) {
                    $monthStart = $start->copy()->addMonths($i);
                    $monthEnd = $monthStart->copy()->endOfMonth();

                    $count = \App\Models\User::where('association_id', $associationId)
                        ->whereBetween('created_at', [$monthStart, $monthEnd])
                        ->count();

                    $labels[] = $monthStart->format('M Y');
                    $values[] = $count;
                }
            } else {
                for ($i = $range - 1; $i >= 0; $i--) {
                    $monthStart = now()->startOfMonth()->subMonths($i);
                    $monthEnd = $monthStart->copy()->endOfMonth();

                    $count = \App\Models\User::where('association_id', $associationId)
                        ->whereBetween('created_at', [$monthStart, $monthEnd])
                        ->count();

                    $labels[] = $monthStart->format('M Y');
                    $values[] = $count;
                }
            }

            $data[$range] = [
                'categories' => $labels,
                'data' => $values,
            ];
        }

        return $data;
    }

    /**
     * Board statistics data.
     */
    protected function getBoardStatisticsData(): array
    {
        $auth = auth()->user();
        $associationId = $auth->association_id;

        // Total active members
        $totalActiveMembers = \App\Models\User::where('association_id', $associationId)
            ->where('is_active', true)
            ->count();

        // Member growth chart data
        $memberGrowthChartData = $this->generateAdminMemberGrowthData($associationId);

        // Cotisations sums (this year)
        $cotisationsPaidMAD = \App\Models\Cotisation::where('association_id', $associationId)
            ->where('status', 1)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');

        $cotisationsPendingMAD = \App\Models\Cotisation::where('association_id', $associationId)
            ->where('status', 0)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $cotisationsOverdueRejectedMAD = \App\Models\Cotisation::where('association_id', $associationId)
            ->whereIn('status', [2, 3])
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        // Cotisation cashflow this year
        $cashflowLabels = [];
        $cashflowValues = [];

        for ($i = 11; $i >= 0; $i--) {
            $monthStart = now()->startOfMonth()->subMonths($i);
            $monthEnd = $monthStart->copy()->endOfMonth();

            $sum = \App\Models\Cotisation::where('association_id', $associationId)
                ->where('status', 1)
                ->whereBetween('paid_at', [$monthStart, $monthEnd])
                ->sum('amount');

            $cashflowLabels[] = $monthStart->format('M Y');
            $cashflowValues[] = $sum;
        }

        // Active events count (this year)
        $activeEvents = \App\Models\Event::where('association_id', $associationId)
            ->whereYear('start_datetime', now()->year)
            ->count();

        return [
            'totalActiveMembers' => $totalActiveMembers,
            'memberGrowthChartData' => $memberGrowthChartData,
            'cotisationsPaidMAD' => $cotisationsPaidMAD,
            'cotisationsPendingMAD' => $cotisationsPendingMAD,
            'cotisationsOverdueRejectedMAD' => $cotisationsOverdueRejectedMAD,
            'cashflowLabels' => $cashflowLabels,
            'cashflowValues' => collect($cashflowValues),
            'activeEvents' => $activeEvents,
        ];
    }
    protected function generateBoardMemberGrowthData(int $associationId): array
    {
        $data = [];

        foreach ([6, 12, 'all'] as $range) {
            $labels = [];
            $values = [];

            if ($range === 'all') {
                $firstMember = \App\Models\User::where('association_id', $associationId)
                    ->orderBy('created_at')
                    ->first();

                $start = $firstMember
                    ? $firstMember->created_at->copy()->startOfMonth()
                    : now()->startOfMonth();

                $end = now()->startOfMonth();

                $monthsDiff = $start->diffInMonths($end) + 1;

                for ($i = 0; $i < $monthsDiff; $i++) {
                    $monthStart = $start->copy()->addMonths($i);
                    $monthEnd = $monthStart->copy()->endOfMonth();

                    $count = \App\Models\User::where('association_id', $associationId)
                        ->whereBetween('created_at', [$monthStart, $monthEnd])
                        ->count();

                    $labels[] = $monthStart->format('M Y');
                    $values[] = $count;
                }
            } else {
                for ($i = $range - 1; $i >= 0; $i--) {
                    $monthStart = now()->startOfMonth()->subMonths($i);
                    $monthEnd = $monthStart->copy()->endOfMonth();

                    $count = \App\Models\User::where('association_id', $associationId)
                        ->whereBetween('created_at', [$monthStart, $monthEnd])
                        ->count();

                    $labels[] = $monthStart->format('M Y');
                    $values[] = $count;
                }
            }

            $data[$range] = [
                'categories' => $labels,
                'data' => $values,
            ];
        }

        return $data;
    }

    /**
     * Supervisor statistics data.
     */
    protected function getSupervisorStatisticsData(): array
    {
        $auth = auth()->user();
        $associationId = $auth->association_id;

        // ✅ New members over the last 6 months (default)
        $months = 6;
        $currentPeriodCount = \App\Models\User::where('association_id', $associationId)
            ->where('is_active', true)
            ->whereBetween('created_at', [
                now()->startOfMonth()->subMonths($months - 1),
                now()->endOfMonth()
            ])
            ->count();

        // Previous period for growth %
        $previousPeriodCount = \App\Models\User::where('association_id', $associationId)
            ->where('is_active', true)
            ->whereBetween('created_at', [
                now()->startOfMonth()->subMonths($months * 2 - 1),
                now()->startOfMonth()->subMonths($months)
            ])
            ->count();

        $growthPercent = $previousPeriodCount > 0
            ? round((($currentPeriodCount - $previousPeriodCount) / $previousPeriodCount) * 100, 1)
            : ($currentPeriodCount > 0 ? 100 : 0);

        // ✅ Member growth chart data (3, 6, 12 months)
        $memberGrowthChartData = $this->generateSupervisorMemberGrowthData($associationId);

        // ✅ Meetings created/completed (this year)
        $createdMeetings = \App\Models\Meeting::where('association_id', $associationId)
            ->whereYear('datetime', now()->year)
            ->count();

        $completedMeetings = \App\Models\Meeting::where('association_id', $associationId)
            ->whereYear('datetime', now()->year)
            ->where('status', 1)
            ->count();

        // ✅ Total events (no type grouping)
        $totalEvents = \App\Models\Event::where('association_id', $associationId)
            ->whereYear('start_datetime', now()->year)
            ->count();

        $eventTypes = [
            'All Events' => $totalEvents,
        ];

        $eventTypeColors = [
            'All Events' => 'primary',
        ];

        // ✅ Documents uploaded to meetings (this year)
        $documentsUploaded = \App\Models\MeetingDocument::whereHas('meeting', function ($q) use ($associationId) {
            $q->where('association_id', $associationId)
                ->whereYear('created_at', now()->year);
        })->count();

        // ✅ Monthly documents chart
        $cashflowLabels = [];
        $cashflowValues = [];

        for ($i = 11; $i >= 0; $i--) {
            $monthStart = now()->startOfMonth()->subMonths($i);
            $monthEnd = $monthStart->copy()->endOfMonth();

            $count = \App\Models\MeetingDocument::whereHas('meeting', function ($q) use ($associationId, $monthStart, $monthEnd) {
                $q->where('association_id', $associationId)
                    ->whereBetween('created_at', [$monthStart, $monthEnd]);
            })->count();

            $cashflowLabels[] = $monthStart->format('M Y');
            $cashflowValues[] = $count;
        }

        return [
            'totalNewMembers' => $currentPeriodCount,
            'growthPercent' => $growthPercent,
            'memberGrowthChartData' => $memberGrowthChartData,
            'createdMeetings' => $createdMeetings,
            'completedMeetings' => $completedMeetings,
            'eventTypes' => $eventTypes,
            'eventTypeColors' => $eventTypeColors,
            'documentsUploaded' => $documentsUploaded,
            'cashflowLabels' => $cashflowLabels,
            'cashflowValues' => collect($cashflowValues),
        ];
    }


    protected function generateSupervisorMemberGrowthData(int $associationId): array
    {
        $data = [];

        foreach ([3, 6, 12] as $months) {
            $labels = [];
            $values = [];

            for ($i = $months - 1; $i >= 0; $i--) {
                $monthStart = now()->startOfMonth()->subMonths($i);
                $monthEnd = $monthStart->copy()->endOfMonth();

                $count = \App\Models\User::where('association_id', $associationId)
                    ->where('is_active', true)
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->count();

                $labels[] = $monthStart->format('M Y');
                $values[] = $count;
            }

            $data[$months] = [
                'categories' => $labels,
                'data' => $values,
            ];
        }

        return $data;
    }

    /**
     * Member statistics data.
     */
    protected function getMemberStatisticsData(): array
    {
        $auth = auth()->user();

        // 1️⃣ Cotisations totals this year
        $cotisations = \App\Models\Cotisation::where('user_id', $auth->id)
            ->whereYear('paid_at', now()->year)
            ->get();

        $totals = [
            'paid' => $cotisations->where('status', 1)->sum('amount'),
            'pending' => $cotisations->where('status', 0)->sum('amount'),
            'overdue' => $cotisations->where('status', 2)->sum('amount'),
            'rejected' => $cotisations->where('status', 3)->sum('amount'),
        ];

        // 2️⃣ Cotisation cashflow (last 12 months)
        $cashflowLabels = [];
        $cashflowValues = [];

        for ($i = 11; $i >= 0; $i--) {
            $monthStart = now()->startOfMonth()->subMonths($i);
            $monthEnd = $monthStart->copy()->endOfMonth();

            $sum = \App\Models\Cotisation::where('user_id', $auth->id)
                ->where('status', 1)
                ->whereBetween('paid_at', [$monthStart, $monthEnd])
                ->sum('amount');

            $cashflowLabels[] = $monthStart->format('M Y');
            $cashflowValues[] = $sum;
        }

        // 3️⃣ Upcoming meetings & events
        $upcomingMeetings = \App\Models\Meeting::where('association_id', $auth->association_id)
            ->where('datetime', '>', now())
            ->orderBy('datetime')
            ->take(5)
            ->get()
            ->map(function ($meeting) {
                return [
                    'title' => $meeting->title,
                    'date' => $meeting->datetime->format('d M Y H:i'),
                    'location' => $meeting->location,
                    'time_diff' => $meeting->datetime->diffForHumans(),
                    'link' => route('admin.meetings.show', $meeting->id),
                ];
            })
            ->toArray();


        $upcomingEvents = \App\Models\Event::where('association_id', $auth->association_id)
            ->where('start_datetime', '>', now())
            ->orderBy('start_datetime')
            ->take(5)
            ->get()
            ->map(function ($event) {
                return [
                    'title' => $event->title,
                    'date' => $event->start_datetime->format('d M Y H:i'),
                    'location' => $event->location,
                    'time_diff' => $event->start_datetime->diffForHumans(),
                    'link' => route('admin.events.show', $event->id),
                ];
            })->toArray();

        $allUpcoming = collect([...$upcomingMeetings, ...$upcomingEvents])
            ->sortBy('date')
            ->values()
            ->take(5)
            ->toArray();

        // 4️⃣ Prepare growth data for chart ranges
        $cashflowGrowthData = [];

        foreach ([6, 12] as $months) {
            $labels = [];
            $values = [];

            for ($i = $months - 1; $i >= 0; $i--) {
                $monthStart = now()->startOfMonth()->subMonths($i);
                $monthEnd = $monthStart->copy()->endOfMonth();

                $sum = \App\Models\Cotisation::where('user_id', $auth->id)
                    ->where('status', 1)
                    ->whereBetween('paid_at', [$monthStart, $monthEnd])
                    ->sum('amount');

                $labels[] = $monthStart->format('M Y');
                $values[] = $sum;
            }

            $cashflowGrowthData[$months] = [
                'categories' => $labels,
                'data' => $values,
            ];
        }

        return [
            'myCotisations' => $totals,
            'cashflowLabels' => $cashflowLabels,
            'cashflowValues' => collect($cashflowValues),
            'upcomingMeetingsEvents' => $allUpcoming,
            'cashflowGrowthData' => $cashflowGrowthData,
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
