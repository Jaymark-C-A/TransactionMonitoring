<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

class VisitorQueueController extends Controller
{
    public function getTodayVisitors()
    {
        $today = Carbon::today();
        $count = Visitor::whereDate('created_at', $today)->count();
        return response()->json(['count' => $count]);
    }

    public function getTodayServed()
    {
        $today = Carbon::today();
        $count = Visitor::whereDate('created_at', $today)
                        ->where('status', 'completed')
                        ->count();
        return response()->json(['count' => $count]);
    }

    public function getTodayNoShow()
    {
        $today = Carbon::today();
        $count = Visitor::whereDate('created_at', $today)
                        ->where('status', 'canceled')
                        ->count();
        return response()->json(['count' => $count]);
    }

    public function getTodayServing()
    {
        $today = Carbon::today();
        $count = Visitor::whereDate('created_at', $today)
                        ->where('status', 'serving')
                        ->count();
        return response()->json(['count' => $count]);
    }
}

