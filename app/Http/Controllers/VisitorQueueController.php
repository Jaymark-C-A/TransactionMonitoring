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
    // Dashboard
    public function fetchPendingCount()
    {
        $count = Visitor::where('status', 'pending')->count();
        return response()->json(['count' => $count]);
    }
    public function fetchPendingVisitors()
    {
        $visitors = Visitor::where('status', 'pending')
                            ->select('id', 'name', 'department','status', 'created_at')
                            ->get(); // Fetch all pending visitors with selected fields
        return response()->json(['visitors' => $visitors]);
    }
    public function fetchPendingEmisVisitors()
    {
        $visitors = Visitor::where('status', 'pending')
                            ->where('department', 'records') // Filter by department 'records'
                            ->select('id', 'name', 'department', 'status', 'created_at')
                            ->get(); // Fetch all pending visitors in the 'records' department with selected fields
                            
        return response()->json(['visitors' => $visitors]);
    }
    public function fetchPendingPrincipalVisitors()
    {
        $visitors = Visitor::where('status', 'pending')
                            ->where('department', 'Clinic') // Filter by department 'records'
                            ->select('id', 'name', 'department', 'status', 'created_at')
                            ->get(); // Fetch all pending visitors in the 'records' department with selected fields
                            
        return response()->json(['visitors' => $visitors]);
    }
    public function fetchPendingAccVisitors()
    {
        $visitors = Visitor::where('status', 'pending')
                            ->where('department', 'accounting') // Filter by department 'records'
                            ->select('id', 'name', 'department', 'status', 'created_at')
                            ->get(); // Fetch all pending visitors in the 'records' department with selected fields
                            
        return response()->json(['visitors' => $visitors]);
    }
    public function fetchPendingHeadVisitors()
    {
        $visitors = Visitor::where('status', 'pending')
                            ->where('department', 'guidance') // Filter by department 'records'
                            ->select('id', 'name', 'department', 'status', 'created_at')
                            ->get(); // Fetch all pending visitors in the 'records' department with selected fields
                            
        return response()->json(['visitors' => $visitors]);
    }
    public function fetchPendingAdminVisitors()
    {
        $visitors = Visitor::where('status', 'pending')
                            ->where('department', 'admin') // Filter by department 'records'
                            ->select('id', 'name', 'department', 'status', 'created_at')
                            ->get(); // Fetch all pending visitors in the 'records' department with selected fields
                            
        return response()->json(['visitors' => $visitors]);
    }
    public function getPendingVisitors()
    {
        $user = auth()->user();
        $department = $user->department; // Ensure your User model has a 'department' field

        $visitors = Visitor::where('department', $department)
                            ->where('status', 'pending')
                            ->get();
        return response()->json(['visitors' => $visitors]);
    }
    public function show($id)
    {
        $visitor = Visitor::find($id);
        if ($visitor) {
            return response()->json($visitor);
        } else {
            return response()->json(['message' => 'Visitor not found'], 404);
        }
    }
}

