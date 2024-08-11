<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DataController extends Controller
{
    public function setServiceStartTime(Request $request)
    {
        $startTime = $request->input('start_time');
        session(['service_start_time' => $startTime]);
        return response()->json(['status' => 'success']);
    }

    public function getServiceStartTime()
    {
        $startTime = session('service_start_time', null);
        return response()->json(['start_time' => $startTime]);
    }

    public function monitorFetchData()
    {
        $data = Visitor::all();
        return response()->json($data);
    }

    public function fetchData()
    {
        $data = Visitor::where('department', 'accounting')->get();
        return response()->json($data);
    }

    public function nextTicket(Request $request)
    {
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'accounting')->first();
        if ($currentTicket) {
            $currentTicket->status = 'completed';
            $currentTicket->save();
        }

        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'accounting')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }

        $queueData = Visitor::where('status', 'waiting')->where('department', 'accounting')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'queueData' => $queueData,
            'message' => 'Next ticket processed successfully.'
        ]);
    }

    public function cancelTicket(Request $request)
    {
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'accounting')->first();

        if ($currentTicket) {
            $currentTicket->status = 'canceled';
            $currentTicket->save();
        }

        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'accounting')->orderBy('created_at', 'asc')->first();

        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }

        $queueData = Visitor::where('status', 'waiting')->where('department', 'accounting')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'queueData' => $queueData,
            'message' => 'Next ticket processed successfully.'
        ]);
    }
    
    public function pendingTicket(Request $request)
    {
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'accounting')->first();

        if ($currentTicket) {
            $currentTicket->status = 'pending';
            $currentTicket->save();
        }

        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'accounting')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }

        $queueData = Visitor::where('status', 'waiting')->where('department', 'accounting')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'queueData' => $queueData,
            'message' => 'Next ticket processed successfully.'
        ]);
    }
    public function getVisitorData()
    {
        $visitors = Visitor::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                            ->groupBy('date')
                            ->orderBy('date', 'ASC')
                            ->get();

        return response()->json($visitors);
    }

    public function getVisitorCount()
    {
        $visitorCount = Visitor::count();
        return response()->json(['count' => $visitorCount]);
    }

    public function fetchdatas()
    {
        $data = Visitor::where('department', 'records')->get();
        return response()->json($data);
    }

    public function nextTicket1(Request $request)
    {
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'records')->first();

        if ($currentTicket) {
            $currentTicket->status = 'completed';
            $currentTicket->save();
        }

        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'records')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }

        $queueData = Visitor::where('status', 'waiting')->where('department', 'records')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'queueData' => $queueData,
            'message' => 'Next ticket processed successfully.'
        ]);
    }

    public function cancelTicket1(Request $request)
    {
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'records')->first();

        if ($currentTicket) {
            $currentTicket->status = 'canceled';
            $currentTicket->save();
        }

        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'records')->orderBy('created_at', 'asc')->first();

        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }

        $queueData = Visitor::where('status', 'waiting')->where('department', 'records')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'queueData' => $queueData,
            'message' => 'Next ticket processed successfully.'
        ]);
    }
    public function pendingTicket1(Request $request)
    {
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'records')->first();

        if ($currentTicket) {
            $currentTicket->status = 'pending';
            $currentTicket->save();
        }

        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'records')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }

        $queueData = Visitor::where('status', 'waiting')->where('department', 'records')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'queueData' => $queueData,
            'message' => 'Next ticket processed successfully.'
        ]);
    }

    // Admin

    public function fetchdataAdmin()
    {
        $data = Visitor::where('department', 'admin')->get();
        return response()->json($data);
    }

    public function nextTicket2(Request $request)
    {
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'admin')->first();

        if ($currentTicket) {
            $currentTicket->status = 'completed';
            $currentTicket->save();
        }

        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'admin')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }

        $queueData = Visitor::where('status', 'waiting')->where('department', 'admin')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'queueData' => $queueData,
            'message' => 'Next ticket processed successfully.'
        ]);
    }

    public function cancelTicket2(Request $request)
    {
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'admin')->first();

        if ($currentTicket) {
            $currentTicket->status = 'canceled';
            $currentTicket->save();
        }

        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'admin')->orderBy('created_at', 'asc')->first();

        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }

        $queueData = Visitor::where('status', 'waiting')->where('department', 'admin')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'queueData' => $queueData,
            'message' => 'Next ticket processed successfully.'
        ]);
    }
    public function pendingTicket2(Request $request)
    {
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'admin')->first();

        if ($currentTicket) {
            $currentTicket->status = 'pending';
            $currentTicket->save();
        }

        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'admin')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }

        $queueData = Visitor::where('status', 'waiting')->where('department', 'admin')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'queueData' => $queueData,
            'message' => 'Next ticket processed successfully.'
        ]);
    }

    // Department-Head

    public function fetchdatahead()
    {
        $data = Visitor::where('department', 'Department_Head')->get();
        return response()->json($data);
    }

    public function nextTicket3(Request $request)
    {
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'Department_Head')->first();

        if ($currentTicket) {
            $currentTicket->status = 'completed';
            $currentTicket->save();
        }

        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'Department_Head')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }

        $queueData = Visitor::where('status', 'waiting')->where('department', 'Department_Head')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'queueData' => $queueData,
            'message' => 'Next ticket processed successfully.'
        ]);
    }

    public function cancelTicket3(Request $request)
    {
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'Department_Head')->first();

        if ($currentTicket) {
            $currentTicket->status = 'canceled';
            $currentTicket->save();
        }

        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'Department_Head')->orderBy('created_at', 'asc')->first();

        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }

        $queueData = Visitor::where('status', 'waiting')->where('department', 'Department_Head')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'queueData' => $queueData,
            'message' => 'Next ticket processed successfully.'
        ]);
    }
    public function pendingTicket3(Request $request)
    {
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'Department_Head')->first();

        if ($currentTicket) {
            $currentTicket->status = 'pending';
            $currentTicket->save();
        }

        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'Department_Head')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }

        $queueData = Visitor::where('status', 'waiting')->where('department', 'Department_Head')->orderBy('created_at', 'asc')->get();

        return response()->json([
            'queueData' => $queueData,
            'message' => 'Next ticket processed successfully.'
        ]);
    }
}
