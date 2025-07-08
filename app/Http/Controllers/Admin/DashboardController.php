<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\User;
use App\Models\Cotisation;
use App\Models\Meeting;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Dashboard main entry.
     */
    public function index()
    {
        $user = Auth::user();
        $topAssociations = collect();
        if ($user->hasRole('superadmin')) {
            $data = $this->getSuperAdminDashboardData();
            return view('admin.dashboards.superadmin', $data);
        } elseif ($user->hasRole('admin')) {
            $data = $this->getAdminDashboardData();
            return view('admin.dashboards.admin', $data);
        } elseif ($user->hasRole('board')) {
            $data = $this->getBoardDashboardData();
            return view('admin.dashboards.board', $data);
        } elseif ($user->hasRole('supervisor')) {
            $data = $this->getSupervisorDashboardData();
            return view('admin.dashboards.supervisor', $data);
        } elseif ($user->hasRole('member')) {
            $data = $this->getMemberDashboardData();
            return view('admin.dashboards.member', $data);
        }

        abort(403);
    }


    /**
     * Get Super Admin Dashboard data.
     */
    protected function getSuperAdminDashboardData(): array
    {
        $now = Carbon::now();

        // Associations
        $totalAssociations = Association::count();
        $validatedAssociations = Association::where('is_validated', true)->count();
        $pendingAssociations = Association::where('is_validated', false)->count();

        $associations = [
            'total' => $totalAssociations,
            'validated' => $validatedAssociations,
            'pending' => $pendingAssociations,
            'progress' => $totalAssociations > 0
                ? round(($validatedAssociations / $totalAssociations) * 100, 1)
                : 0,
        ];

        // Users
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();

        $users = [
            'total' => $totalUsers,
            'active' => $activeUsers,
            'inactive' => $inactiveUsers,
            'progress' => $totalUsers > 0
                ? round(($activeUsers / $totalUsers) * 100, 1)
                : 0,
        ];

        // Cotisations
        $totalCotisations = Cotisation::sum('amount');
        $cotisations = [
            'total' => $totalCotisations,
        ];

        $cotisationsStatus = [
            'paid' => Cotisation::where('status', Cotisation::STATUS_PAID)->count(),
            'pending' => Cotisation::where('status', Cotisation::STATUS_PENDING)->count(),
            'overdue' => Cotisation::where('status', Cotisation::STATUS_OVERDUE)->count(),
            'rejected' => Cotisation::where('status', Cotisation::STATUS_REJECTED)->count(),
        ];

        // Meetings
        $totalMeetings = Meeting::count();
        $upcomingMeetings = Meeting::where('datetime', '>=', $now)->count();

        $meetings = [
            'held' => $totalMeetings,
            'upcoming' => $upcomingMeetings,
        ];

        // Events
        $activeEvents = Event::where('status', 1)->count();

        $events = [
            'active' => $activeEvents,
            'attendees' => 0,
        ];

        // Cashflow for charts

        // --- Last 30 days (daily sums) ---
        $cashflow30 = Cotisation::select(
            DB::raw("DATE_FORMAT(paid_at, '%Y-%m-%d') as day"),
            DB::raw('SUM(amount) as total')
        )
            ->where('status', Cotisation::STATUS_PAID)
            ->whereNotNull('paid_at')
            ->where('paid_at', '>=', $now->copy()->subDays(30)->startOfDay())
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $days30 = $cashflow30->pluck('day')->toArray();
        $totals30 = $cashflow30->pluck('total')->toArray();

        // --- Last 6 months (monthly sums) ---
        $cashflow180 = Cotisation::select(
            DB::raw("DATE_FORMAT(paid_at, '%Y-%m') as month"),
            DB::raw('SUM(amount) as total')
        )
            ->where('status', Cotisation::STATUS_PAID)
            ->whereNotNull('paid_at')
            ->where('paid_at', '>=', $now->copy()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months180 = $cashflow180->pluck('month')->toArray();
        $totals180 = $cashflow180->pluck('total')->toArray();

        // --- Last 365 days (monthly sums) ---
        $cashflow365 = Cotisation::select(
            DB::raw("DATE_FORMAT(paid_at, '%Y-%m') as month"),
            DB::raw('SUM(amount) as total')
        )
            ->where('status', Cotisation::STATUS_PAID)
            ->whereNotNull('paid_at')
            ->where('paid_at', '>=', $now->copy()->subDays(365)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months365 = $cashflow365->pluck('month')->toArray();
        $totals365 = $cashflow365->pluck('total')->toArray();

        $cashflowData = [
            '30' => [
                'categories' => $days30,
                'series' => [
                    [
                        'name' => 'Cotisations',
                        'data' => $totals30,
                    ]
                ],
            ],
            '180' => [
                'categories' => $months180,
                'series' => [
                    [
                        'name' => 'Cotisations',
                        'data' => $totals180,
                    ]
                ],
            ],
            '365' => [
                'categories' => $months365,
                'series' => [
                    [
                        'name' => 'Cotisations',
                        'data' => $totals365,
                    ]
                ],
            ],
        ];

        // Top Associations
        $topAssociations = Association::leftJoin('users', 'users.association_id', '=', 'associations.id')
            ->leftJoin('cotisations', 'cotisations.association_id', '=', 'associations.id')
            ->leftJoin('meetings', 'meetings.association_id', '=', 'associations.id')
            ->select(
                'associations.id',
                'associations.name',
                DB::raw('COUNT(DISTINCT users.id) as members'),
                DB::raw('SUM(cotisations.amount) as cotisations'),
                DB::raw('COUNT(DISTINCT meetings.id) as meetings'),
                'associations.is_validated'
            )
            ->groupBy('associations.id', 'associations.name', 'associations.is_validated')
            ->orderByDesc(DB::raw('SUM(cotisations.amount)'))
            ->limit(5)
            ->get()
            ->map(function ($assoc) {
                return [
                    'name' => $assoc->name,
                    'members' => $assoc->members,
                    'cotisations' => $assoc->cotisations ?? 0,
                    'meetings' => $assoc->meetings,
                    'status_label' => $assoc->is_validated ? 'Active' : 'Pending Approval',
                    'status_color' => $assoc->is_validated ? 'success' : 'warning',
                ];
            })
            ->toArray();

        return compact(
            'associations',
            'users',
            'cotisations',
            'cotisationsStatus',
            'meetings',
            'events',
            'topAssociations',
            'cashflowData'
        );
    }

    /**
     * Get Admin Dashboard data.
     */
    protected function getAdminDashboardData(): array
    {
        $now = Carbon::now();
        $user = Auth::user();
        $associationId = $user->association_id;

        // Association info
        $association = Association::find($associationId);

        // Users
        $activeUsers = User::where('association_id', $associationId)
            ->where('is_active', true)
            ->count();

        $inactiveUsers = User::where('association_id', $associationId)
            ->where('is_active', false)
            ->count();

        $totalUsers = $activeUsers + $inactiveUsers;

        $users = [
            'total' => $totalUsers,
            'active' => $activeUsers,
            'inactive' => $inactiveUsers,
            'progress' => $totalUsers > 0
                ? round(($activeUsers / $totalUsers) * 100, 1)
                : 0,
        ];

        // Cotisations
        $totalCotisations = Cotisation::where('association_id', $associationId)->sum('amount');

        $cotisations = [
            'total' => $totalCotisations,
        ];

        $cotisationsStatus = [
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

        // Meetings
        $totalMeetings = Meeting::where('association_id', $associationId)->count();
        $upcomingMeetings = Meeting::where('association_id', $associationId)
            ->where('datetime', '>=', $now)
            ->count();

        $meetings = [
            'held' => $totalMeetings,
            'upcoming' => $upcomingMeetings,
        ];

        // Events
        $activeEvents = Event::where('association_id', $associationId)
            ->where('status', 1)
            ->count();

        $events = [
            'active' => $activeEvents,
        ];

        // Cashflow for charts (past 12 months)
        $cashflow = Cotisation::select(
            DB::raw("DATE_FORMAT(paid_at, '%Y-%m') as month"),
            DB::raw('SUM(amount) as total')
        )
            ->where('association_id', $associationId)
            ->where('status', Cotisation::STATUS_PAID)
            ->whereNotNull('paid_at')
            ->where('paid_at', '>=', $now->copy()->subMonths(12)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $cashflowMonths = $cashflow->pluck('month')->toArray();
        $cashflowTotals = $cashflow->pluck('total')->toArray();

        $cashflowData = [
            '180' => [
                'categories' => $cashflowMonths,
                'series' => [
                    [
                        'name' => 'Cotisations',
                        'data' => $cashflowTotals,
                    ]
                ],
            ],
            '30' => [
                'categories' => [],
                'series' => [[]],
            ],
            '365' => [
                'categories' => [],
                'series' => [[]],
            ],
        ];

        // Recent activities
        $recentActivities = collect([
            (object)[
                'member_name'   => 'John Doe',
                'action'        => 'Joined meeting',
                'details'       => 'Annual Review',
                'activity_time' => now()->subMinutes(15),
            ],
            (object)[
                'member_name'   => 'Jane Smith',
                'action'        => 'Paid cotisation',
                'details'       => 'Amount: 1200 MAD',
                'activity_time' => now()->subHours(2),
            ],
            (object)[
                'member_name'   => 'Ahmed Ben',
                'action'        => 'Created event',
                'details'       => 'Summer Workshop',
                'activity_time' => now()->subDays(1),
            ],
        ]);


        return compact(
            'association',
            'users',
            'cotisations',
            'cotisationsStatus',
            'meetings',
            'events',
            'cashflowData',
            'recentActivities'
        );
    }

    protected function getBoardDashboardData(): array
    {
        $now = Carbon::now();
        $user = Auth::user();
        $associationId = $user->association_id;

        // Association info
        $association = Association::find($associationId);

        // Users
        $activeUsers = User::where('association_id', $associationId)
            ->where('is_active', true)
            ->count();

        $inactiveUsers = User::where('association_id', $associationId)
            ->where('is_active', false)
            ->count();

        $totalUsers = $activeUsers + $inactiveUsers;

        $users = [
            'total' => $totalUsers,
            'active' => $activeUsers,
            'inactive' => $inactiveUsers,
            'progress' => $totalUsers > 0
                ? round(($activeUsers / $totalUsers) * 100, 1)
                : 0,
        ];

        // Cotisations
        $totalCotisations = Cotisation::where('association_id', $associationId)->sum('amount');

        $cotisations = [
            'total' => $totalCotisations,
        ];

        $cotisationsStatus = [
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

        // Meetings
        $totalMeetings = Meeting::where('association_id', $associationId)->count();
        $upcomingMeetings = Meeting::where('association_id', $associationId)
            ->where('datetime', '>=', $now)
            ->count();

        $meetings = [
            'held' => $totalMeetings,
            'upcoming' => $upcomingMeetings,
        ];

        // Events
        $activeEvents = Event::where('association_id', $associationId)
            ->where('status', 1)
            ->count();

        $events = [
            'active' => $activeEvents,
        ];

        // Cashflow chart (last 12 months)
        $cashflow = Cotisation::select(
            DB::raw("DATE_FORMAT(paid_at, '%Y-%m') as month"),
            DB::raw('SUM(amount) as total')
        )
            ->where('association_id', $associationId)
            ->where('status', Cotisation::STATUS_PAID)
            ->whereNotNull('paid_at')
            ->where('paid_at', '>=', $now->copy()->subMonths(12)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $cashflowMonths = $cashflow->pluck('month')->toArray();
        $cashflowTotals = $cashflow->pluck('total')->toArray();

        $cashflowData = [
            '180' => [
                'categories' => $cashflowMonths,
                'series' => [
                    [
                        'name' => 'Cotisations',
                        'data' => $cashflowTotals,
                    ]
                ],
            ],
            '30' => [
                'categories' => [],
                'series' => [[]],
            ],
            '365' => [
                'categories' => [],
                'series' => [[]],
            ],
        ];

        // Recent activities (static for now)
        $recentActivities = collect([
            (object)[
                'member_name'   => 'Sarah Board',
                'action'        => 'Approved cotisation',
                'details'       => 'for Member #1',
                'activity_time' => now()->subHours(1),
            ],
            (object)[
                'member_name'   => 'Board User',
                'action'        => 'Created event',
                'details'       => 'Summer Strategy Session',
                'activity_time' => now()->subDays(1),
            ],
            (object)[
                'member_name'   => 'Member X',
                'action'        => 'Participated in meeting',
                'details'       => 'Budget Planning',
                'activity_time' => now()->subDays(2),
            ],
        ]);

        return compact(
            'association',
            'users',
            'cotisations',
            'cotisationsStatus',
            'meetings',
            'events',
            'cashflowData',
            'recentActivities'
        );
    }

    /**
     * Get Supervisor Dashboard data.
     */
    protected function getSupervisorDashboardData(): array
    {
        $now = Carbon::now();
        $user = Auth::user();
        $associationId = $user->association_id;

        // Association info
        $association = Association::find($associationId);

        // Users
        $activeUsers = User::where('association_id', $associationId)
            ->where('is_active', true)
            ->count();

        $inactiveUsers = User::where('association_id', $associationId)
            ->where('is_active', false)
            ->count();

        $totalUsers = $activeUsers + $inactiveUsers;

        $users = [
            'total' => $totalUsers,
            'active' => $activeUsers,
            'inactive' => $inactiveUsers,
            'progress' => $totalUsers > 0
                ? round(($activeUsers / $totalUsers) * 100, 1)
                : 0,
        ];

        // Meetings
        $totalMeetings = Meeting::where('association_id', $associationId)->count();
        $upcomingMeetings = Meeting::where('association_id', $associationId)
            ->where('datetime', '>=', $now)
            ->count();

        $meetings = [
            'held' => $totalMeetings,
            'upcoming' => $upcomingMeetings,
        ];

        // Events
        $activeEvents = Event::where('association_id', $associationId)
            ->where('status', 1)
            ->count();

        $events = [
            'active' => $activeEvents,
        ];

        // Cotisations (supervisors typically only view, not manage amounts)
        $totalCotisations = Cotisation::where('association_id', $associationId)
            ->sum('amount');

        $cotisations = [
            'total' => $totalCotisations,
        ];

        $cotisationsStatus = [
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

        // Cashflow chart (last 12 months)
        $cashflow = Cotisation::select(
            DB::raw("DATE_FORMAT(paid_at, '%Y-%m') as month"),
            DB::raw('SUM(amount) as total')
        )
            ->where('association_id', $associationId)
            ->where('status', Cotisation::STATUS_PAID)
            ->whereNotNull('paid_at')
            ->where('paid_at', '>=', $now->copy()->subMonths(12)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $cashflowMonths = $cashflow->pluck('month')->toArray();
        $cashflowTotals = $cashflow->pluck('total')->toArray();

        $cashflowData = [
            '180' => [
                'categories' => $cashflowMonths,
                'series' => [
                    [
                        'name' => 'Cotisations',
                        'data' => $cashflowTotals,
                    ]
                ],
            ],
            '30' => [
                'categories' => [],
                'series' => [[]],
            ],
            '365' => [
                'categories' => [],
                'series' => [[]],
            ],
        ];

        // Recent activities (static examples)
        $recentActivities = collect([
            (object)[
                'member_name'   => 'Supervisor User',
                'action'        => 'Scheduled a meeting',
                'details'       => 'Board Review',
                'activity_time' => now()->subHours(2),
            ],
            (object)[
                'member_name'   => 'Ali Supervisor',
                'action'        => 'Updated event',
                'details'       => 'Community Workshop',
                'activity_time' => now()->subDays(1),
            ],
            (object)[
                'member_name'   => 'Hassan',
                'action'        => 'Reviewed member profile',
                'details'       => 'Member #12',
                'activity_time' => now()->subDays(2),
            ],
        ]);

        return compact(
            'association',
            'users',
            'cotisations',
            'cotisationsStatus',
            'meetings',
            'events',
            'cashflowData',
            'recentActivities'
        );
    }

    /**
     * Get Member Dashboard data.
     */
    protected function getMemberDashboardData(): array
    {
        $auth = auth()->user();

        // --- 1) Cotisation Summary ---
        $paidTotal = Cotisation::where('user_id', $auth->id)
            ->where('status', Cotisation::STATUS_PAID)
            ->sum('amount');

        $pendingTotal = Cotisation::where('user_id', $auth->id)
            ->where('status', Cotisation::STATUS_PENDING)
            ->sum('amount');

        $overdueTotal = Cotisation::where('user_id', $auth->id)
            ->where('status', Cotisation::STATUS_OVERDUE)
            ->sum('amount');

        // --- 2) Profile completeness (dummy calculation) ---
        // Compute from user's actual filled fields instead of statistics table
        $fields = [
            $auth->name,
            $auth->email,
            $auth->phone,
            $auth->address,
        ];

        $filled = collect($fields)->filter(fn($v) => !empty($v))->count();
        $total = count($fields);

        $profileCompletion = $total > 0
            ? round(($filled / $total) * 100, 1)
            : 0;

        // --- 3) Cotisation Chart (Last 6 months) ---
        $cashflow = Cotisation::select(
            DB::raw("DATE_FORMAT(paid_at, '%Y-%m') as month"),
            DB::raw("SUM(amount) as total")
        )
            ->where('user_id', $auth->id)
            ->where('status', Cotisation::STATUS_PAID)
            ->whereNotNull('paid_at')
            ->where('paid_at', '>=', now()->copy()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $cashflowLabels = $cashflow->pluck('month')->toArray();
        $cashflowValues = $cashflow->pluck('total')->toArray();

        // --- 4) My Cotisation History ---
        $myCotisationsList = Cotisation::where('user_id', $auth->id)
            ->select([
                DB::raw('year as cycle'),
                'amount',
                DB::raw('IFNULL(paid_at, "N/A") as due_date'),
                'status',
            ])
            ->orderByDesc('year')
            ->limit(10)
            ->get();

        // --- 5) Upcoming Meetings & Events ---
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

        // --- 6) Recent Activities (dummy) ---
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
            'profileCompletion' => $profileCompletion,
            'paidTotal' => $paidTotal,
            'pendingTotal' => $pendingTotal,
            'overdueTotal' => $overdueTotal,
            'cashflowLabels' => $cashflowLabels,
            'cashflowValues' => $cashflowValues,
            'myCotisationsList' => $myCotisationsList,
            'upcomingMeetingsEvents' => $upcomingMeetingsEvents,
            'recentActivities' => $recentActivities,
        ];
    }
}
