<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class PendingVisitorController extends Controller
{
    public function markAsCompleted(Request $request)
    {
    $visitorId = $request->input('visitor_id');
    $visitor = Visitor::find($visitorId);
        if ($visitor) {
            $visitor->status = 'completed';
            $visitor->save();
            return redirect()->back()->with('success', 'Visitor status updated to completed');
        } else {
            return redirect()->back()->with('error', 'Visitor not found');
        }
    }
    public function markAsCanceled(Request $request)
    {
        $visitorId = $request->input('visitor_id');
        $visitor = Visitor::find($visitorId);
        if ($visitor) {
            $visitor->status = 'canceled';
            $visitor->save();
            return redirect()->back()->with('success', 'Visitor status updated to canceled');
        } else {
            return redirect()->back()->with('error', 'Visitor not found');
        }
    }
}


