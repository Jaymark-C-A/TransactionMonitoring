<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OfficeDashboardController extends Controller
{
    public function index()
    {
        $department = '';
        if (Auth::user()->hasRole('Clinic')) {
            $department = 'clinic';
        } elseif  (Auth::user()->hasRole('Records')) {
            $department = 'records';
        } elseif (Auth::user()->hasRole('Admin')) {
            $department = 'admin';
        } elseif (Auth::user()->hasRole('Guidance')) {
            $department = 'guidance';
        } elseif (Auth::user()->hasRole('Accounting')) {
            $department = 'accounting';
        }
        $todayVisitors = Visitor::whereDate('created_at', Carbon::today())
            ->when($department, function ($query) use ($department) {
                return $query->where('department', $department);
            })
            ->count();
        $yesterdayVisitors = Visitor::whereDate('created_at', Carbon::yesterday())
            ->when($department, function ($query) use ($department) {
                return $query->where('department', $department);
            })
            ->count();
        $totalVisitors = Visitor::when($department, function ($query) use ($department) {
            return $query->where('department', $department);
        })->count();
        $totalCanceledTransactions = Visitor::where('status', 'canceled')
            ->when($department, function ($query) use ($department) {
                return $query->where('department', $department);
            })
            ->count();
        $totalPendingTransactions = Visitor::where('status', 'pending')
            ->when($department, function ($query) use ($department) {
                return $query->where('department', $department);
            })
            ->count();
        $todayCanceledTransactions = Visitor::where('status', 'canceled')
            ->whereDate('created_at', Carbon::today())
            ->when($department, function ($query) use ($department) {
                return $query->where('department', $department);
            })
            ->count();
        $todayPendingTransactions = Visitor::where('status', 'pending')
            ->whereDate('created_at', Carbon::today())
            ->when($department, function ($query) use ($department) {
                return $query->where('department', $department);
            })
            ->count();
        return response()->json([
            'totalVisitors' => $totalVisitors,
            'yesterdayVisitors' => $yesterdayVisitors,
            'todayVisitors' => $todayVisitors,
            'totalCanceledTransactions' => $totalCanceledTransactions,
            'todayCanceledTransactions' => $todayCanceledTransactions,
            'totalPendingTransactions' => $totalPendingTransactions,
            'todayPendingTransactions' => $todayPendingTransactions,
        ]);
    }
    public function getMonthlyVisitors()
    {
        $department = ''; // Initialize the department variable
        if (Auth::user()->hasRole('Clinic')) {
            $department = 'clinic';
        } elseif  (Auth::user()->hasRole('Records')) {
            $department = 'records';
        } elseif (Auth::user()->hasRole('Admin')) {
            $department = 'admin';
        } elseif (Auth::user()->hasRole('Guidance')) {
            $department = 'guidance';
        } elseif (Auth::user()->hasRole('Accounting')) {
            $department = 'accounting';
        }
        $monthlyVisitors = Visitor::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->when($department, function ($query) use ($department) {
                return $query->where('department', $department);
            })
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        $monthNames = [
            1 => 'January', 2 => 'February', 3 => 'March',
            4 => 'April', 5 => 'May', 6 => 'June',
            7 => 'July', 8 => 'August', 9 => 'September',
            10 => 'October', 11 => 'November', 12 => 'December'
        ];
        $monthlyVisitorsWithNames = $monthlyVisitors->map(function($item) use ($monthNames) {
            return [
                'month' => $monthNames[$item->month],
                'count' => $item->count
            ];
        });
        return response()->json($monthlyVisitorsWithNames);
    }
}
