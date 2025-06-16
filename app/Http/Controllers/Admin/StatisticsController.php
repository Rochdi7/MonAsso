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
        // --- This variable was missing. It's for the "Profit" card and "Earnings" card total. ---
        $totalPaidCotisations = Cotisation::where('status', Cotisation::STATUS_PAID)->sum('amount');
        
        // --- This variable was also missing. It's for the "Invoiced" card. ---
        $totalCotisationsAllStatus = Cotisation::whereIn('status', [
            Cotisation::STATUS_PAID,
            Cotisation::STATUS_PENDING,
            Cotisation::STATUS_OVERDUE
        ])->sum('amount');

        // --- This is for the "Member Growth" card. ---
        $newRegistrations = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        // --- Data for the dynamic "Monthly Income" chart ---
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

        // --- Data for the dynamic "Member Growth" chart ---
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

        // --- Data for the dynamic "Cotisation Status" donut chart ---
        $statusCounts = [
            'paid' => Cotisation::where('status', Cotisation::STATUS_PAID)->count(),
            'pending' => Cotisation::where('status', Cotisation::STATUS_PENDING)->count(),
            'overdue' => Cotisation::where('status', Cotisation::STATUS_OVERDUE)->count(),
            'rejected' => Cotisation::where('status', Cotisation::STATUS_REJECTED)->count(),
        ];

        // ----------------------------------------
        // Pass the CORRECT data to the view
        // ----------------------------------------
        return view('admin.statistics.index', compact(
            'totalPaidCotisations',
            'totalCotisationsAllStatus',
            'newRegistrations',
            'cashflowLabels',
            'cashflowValues',
            'newUserLabels',
            'newUserValues',
            'statusCounts'
        ));
    }
}