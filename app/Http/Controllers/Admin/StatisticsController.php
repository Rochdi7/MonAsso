<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\User;
use App\Models\Cotisation;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        $auth = auth()->user();

        // Global Metrics (can be used in any view)
        $totalPaidCotisations = Cotisation::where('status', Cotisation::STATUS_PAID)->sum('amount');
        $totalCotisationsAllStatus = Cotisation::whereIn('status', [
            Cotisation::STATUS_PAID,
            Cotisation::STATUS_PENDING,
            Cotisation::STATUS_OVERDUE
        ])->sum('amount');

        $newRegistrations = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        $cashflowData = Cotisation::select(
                DB::raw('SUM(amount) as total'),
                DB::raw("DATE_FORMAT(paid_at, '%b') as month")
            )
            ->where('status', Cotisation::STATUS_PAID)
            ->where('paid_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderByRaw("MIN(paid_at) ASC")
            ->get();

        $cashflowLabels = $cashflowData->pluck('month');
        $cashflowValues = $cashflowData->pluck('total');

        $newUsersData = User::select(
                DB::raw('COUNT(id) as count'),
                DB::raw("DATE_FORMAT(created_at, '%b') as month")
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderByRaw("MIN(created_at) ASC")
            ->get();

        $newUserLabels = $newUsersData->pluck('month');
        $newUserValues = $newUsersData->pluck('count');

        $statusCounts = [
            'paid' => Cotisation::where('status', Cotisation::STATUS_PAID)->count(),
            'pending' => Cotisation::where('status', Cotisation::STATUS_PENDING)->count(),
            'overdue' => Cotisation::where('status', Cotisation::STATUS_OVERDUE)->count(),
            'rejected' => Cotisation::where('status', Cotisation::STATUS_REJECTED)->count(),
        ];

        // Shared data for all views
        $data = compact(
            'totalPaidCotisations',
            'totalCotisationsAllStatus',
            'newRegistrations',
            'cashflowLabels',
            'cashflowValues',
            'newUserLabels',
            'newUserValues',
            'statusCounts'
        );

        // Return view based on user role
        if ($auth->hasRole('superadmin')) {
            return view('admin.statistics.superadmin', $data);
        } elseif ($auth->hasRole('admin')) {
            return view('admin.statistics.admin', $data);
        } elseif ($auth->hasRole('board')) {
            return view('admin.statistics.board', $data);
        } elseif ($auth->hasRole('supervisor')) {
            return view('admin.statistics.supervisor', $data);
        } elseif ($auth->hasRole('member')) {
            return view('admin.statistics.member', $data);
        }

        return abort(403, 'Unauthorized access.');
    }
}
