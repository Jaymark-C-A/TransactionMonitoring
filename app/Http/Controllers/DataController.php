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
        $data = Visitor::where('department', 'accounting')
                       ->orderBy('created_at', 'asc')
                       ->get();
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
    public function skipTicket(Request $request) {
        // Get the current serving ticket
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'accounting')->first();
        
        if ($currentTicket) {
            // Change the current ticket's status back to 'waiting'
            $currentTicket->status = 'waiting';
    
            // Get the list of waiting tickets for the department
            $waitingTickets = Visitor::where('status', 'waiting')->where('department', 'accounting')->orderBy('created_at', 'asc')->get();
            
            // If there are at least two waiting tickets, we can set the skipped ticket in the middle
            if ($waitingTickets->count() > 1) {
                // Find the middle point between the first and last ticket
                $middleIndex = floor($waitingTickets->count() / 2);
                $prevTicket = $waitingTickets[$middleIndex - 1];
                $nextTicket = $waitingTickets[$middleIndex];
    
                // Add 3 seconds to the time between the previous and next ticket to place it in the middle
                $currentTicket->created_at = $prevTicket->created_at->diffInSeconds($nextTicket->created_at) < 3 
                    ? $prevTicket->created_at->addSeconds(3) // Ensure there's at least 3 seconds between them
                    : $prevTicket->created_at->addSeconds(1);
            }
            else {
                // If there's only one ticket in the queue, we can just add a 3 second delay after it
                $currentTicket->created_at = $waitingTickets->first()->created_at->addSeconds(3);
            }
    
            // Save the updated skipped ticket
            $currentTicket->save();
        }
    
        // Find the next waiting ticket and promote it to 'serving'
        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'accounting')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }
    
        // Fetch updated queue data
        $queueData = Visitor::where('department', 'accounting')
                            ->where('status', 'waiting')
                            ->orderBy('created_at', 'asc')
                            ->get();
    
        return response()->json([
            'currentServing' => $nextTicket, // Provide the new serving ticket
            'queueData' => $queueData,       // Updated queue list
            'message' => 'Ticket skipped successfully, and the next ticket is now serving.'
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
        $data = Visitor::where('department', 'records')
                       ->orderBy('created_at', 'asc')
                       ->get();
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

    public function skipTicket1(Request $request) {
        // Get the current serving ticket
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'records')->first();
        
        if ($currentTicket) {
            // Change the current ticket's status back to 'waiting'
            $currentTicket->status = 'waiting';
    
            // Get the list of waiting tickets for the department
            $waitingTickets = Visitor::where('status', 'waiting')->where('department', 'records')->orderBy('created_at', 'asc')->get();
            
            // If there are at least two waiting tickets, we can set the skipped ticket in the middle
            if ($waitingTickets->count() > 1) {
                // Find the middle point between the first and last ticket
                $middleIndex = floor($waitingTickets->count() / 2);
                $prevTicket = $waitingTickets[$middleIndex - 1];
                $nextTicket = $waitingTickets[$middleIndex];
    
                // Add 3 seconds to the time between the previous and next ticket to place it in the middle
                $currentTicket->created_at = $prevTicket->created_at->diffInSeconds($nextTicket->created_at) < 3 
                    ? $prevTicket->created_at->addSeconds(3) // Ensure there's at least 3 seconds between them
                    : $prevTicket->created_at->addSeconds(1);
            }
            else {
                // If there's only one ticket in the queue, we can just add a 3 second delay after it
                $currentTicket->created_at = $waitingTickets->first()->created_at->addSeconds(3);
            }
    
            // Save the updated skipped ticket
            $currentTicket->save();
        }
    
        // Find the next waiting ticket and promote it to 'serving'
        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'records')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }
    
        // Fetch updated queue data
        $queueData = Visitor::where('department', 'records')
                            ->where('status', 'waiting')
                            ->orderBy('created_at', 'asc')
                            ->get();
    
        return response()->json([
            'currentServing' => $nextTicket, // Provide the new serving ticket
            'queueData' => $queueData,       // Updated queue list
            'message' => 'Ticket skipped successfully, and the next ticket is now serving.'
        ]);
    }
    
    
    

    // Admin
    public function fetchdataAdmin()
    {
        $data = Visitor::where('department', 'admin')
                       ->orderBy('created_at', 'asc')
                       ->get();
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
    public function skipTicket2(Request $request) {
        // Get the current serving ticket
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'admin')->first();
        
        if ($currentTicket) {
            // Change the current ticket's status back to 'waiting'
            $currentTicket->status = 'waiting';
    
            // Get the list of waiting tickets for the department
            $waitingTickets = Visitor::where('status', 'waiting')->where('department', 'admin')->orderBy('created_at', 'asc')->get();
            
            // If there are at least two waiting tickets, we can set the skipped ticket in the middle
            if ($waitingTickets->count() > 1) {
                // Find the middle point between the first and last ticket
                $middleIndex = floor($waitingTickets->count() / 2);
                $prevTicket = $waitingTickets[$middleIndex - 1];
                $nextTicket = $waitingTickets[$middleIndex];
    
                // Add 3 seconds to the time between the previous and next ticket to place it in the middle
                $currentTicket->created_at = $prevTicket->created_at->diffInSeconds($nextTicket->created_at) < 3 
                    ? $prevTicket->created_at->addSeconds(3) // Ensure there's at least 3 seconds between them
                    : $prevTicket->created_at->addSeconds(1);
            }
            else {
                // If there's only one ticket in the queue, we can just add a 3 second delay after it
                $currentTicket->created_at = $waitingTickets->first()->created_at->addSeconds(3);
            }
    
            // Save the updated skipped ticket
            $currentTicket->save();
        }
    
        // Find the next waiting ticket and promote it to 'serving'
        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'admin')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }
    
        // Fetch updated queue data
        $queueData = Visitor::where('department', 'admin')
                            ->where('status', 'waiting')
                            ->orderBy('created_at', 'asc')
                            ->get();
    
        return response()->json([
            'currentServing' => $nextTicket, // Provide the new serving ticket
            'queueData' => $queueData,       // Updated queue list
            'message' => 'Ticket skipped successfully, and the next ticket is now serving.'
        ]);
    }
    
    // Guidance
    public function fetchdatahead()
    {
        $data = Visitor::where('department', 'guidance')
                       ->orderBy('created_at', 'asc')
                       ->get();
        return response()->json($data);    
    }
    public function nextTicket3(Request $request)
    {
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'guidance')->first();
        if ($currentTicket) {
            $currentTicket->status = 'completed';
            $currentTicket->save();
        }
        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'guidance')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }
        $queueData = Visitor::where('status', 'waiting')->where('department', 'guidance')->orderBy('created_at', 'asc')->get();
        return response()->json([
            'queueData' => $queueData,
            'message' => 'Next ticket processed successfully.'
        ]);
    }
    public function cancelTicket3(Request $request)
    {
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'guidance')->first();
        if ($currentTicket) {
            $currentTicket->status = 'canceled';
            $currentTicket->save();
        }
        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'guidance')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }
        $queueData = Visitor::where('status', 'waiting')->where('department', 'guidance')->orderBy('created_at', 'asc')->get();
        return response()->json([
            'queueData' => $queueData,
            'message' => 'Next ticket processed successfully.'
        ]);
    }
    public function skipTicket3(Request $request) {
        // Get the current serving ticket
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'guidance')->first();
        
        if ($currentTicket) {
            // Change the current ticket's status back to 'waiting'
            $currentTicket->status = 'waiting';
    
            // Get the list of waiting tickets for the department
            $waitingTickets = Visitor::where('status', 'waiting')->where('department', 'guidance')->orderBy('created_at', 'asc')->get();
            
            // If there are at least two waiting tickets, we can set the skipped ticket in the middle
            if ($waitingTickets->count() > 1) {
                // Find the middle point between the first and last ticket
                $middleIndex = floor($waitingTickets->count() / 2);
                $prevTicket = $waitingTickets[$middleIndex - 1];
                $nextTicket = $waitingTickets[$middleIndex];
    
                // Add 3 seconds to the time between the previous and next ticket to place it in the middle
                $currentTicket->created_at = $prevTicket->created_at->diffInSeconds($nextTicket->created_at) < 3 
                    ? $prevTicket->created_at->addSeconds(3) // Ensure there's at least 3 seconds between them
                    : $prevTicket->created_at->addSeconds(1);
            }
            else {
                // If there's only one ticket in the queue, we can just add a 3 second delay after it
                $currentTicket->created_at = $waitingTickets->first()->created_at->addSeconds(3);
            }
    
            // Save the updated skipped ticket
            $currentTicket->save();
        }
    
        // Find the next waiting ticket and promote it to 'serving'
        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'guidance')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }
    
        // Fetch updated queue data
        $queueData = Visitor::where('department', 'guidance')
                            ->where('status', 'waiting')
                            ->orderBy('created_at', 'asc')
                            ->get();
    
        return response()->json([
            'currentServing' => $nextTicket, // Provide the new serving ticket
            'queueData' => $queueData,       // Updated queue list
            'message' => 'Ticket skipped successfully, and the next ticket is now serving.'
        ]);
    }

    // Clinic
    public function fetchdataPrin()
    {
        $data = Visitor::where('department', 'clinic')
                       ->orderBy('created_at', 'asc')
                       ->get();
        return response()->json($data);
    }
    public function nextTicket4(Request $request)
    {
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'Clinic')->first();
        if ($currentTicket) {
            $currentTicket->status = 'completed';
            $currentTicket->save();
        }
        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'Clinic')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }
        $queueData = Visitor::where('status', 'waiting')->where('department', 'Clinic')->orderBy('created_at', 'asc')->get();
        return response()->json([
            'queueData' => $queueData,
            'message' => 'Next ticket processed successfully.'
        ]);
    }
    public function cancelTicket4(Request $request)
    {
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'Clinic')->first();
        if ($currentTicket) {
            $currentTicket->status = 'canceled';
            $currentTicket->save();
        }
        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'Clinic')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }
        $queueData = Visitor::where('status', 'waiting')->where('department', 'Clinic')->orderBy('created_at', 'asc')->get();
        return response()->json([
            'queueData' => $queueData,
            'message' => 'Next ticket processed successfully.'
        ]);
    }
    public function skipTicket4(Request $request) {
        // Get the current serving ticket
        $currentTicket = Visitor::where('status', 'serving')->where('department', 'clinic')->first();
        
        if ($currentTicket) {
            // Change the current ticket's status back to 'waiting'
            $currentTicket->status = 'waiting';
    
            // Get the list of waiting tickets for the department
            $waitingTickets = Visitor::where('status', 'waiting')->where('department', 'clinic')->orderBy('created_at', 'asc')->get();
            
            // If there are at least two waiting tickets, we can set the skipped ticket in the middle
            if ($waitingTickets->count() > 1) {
                // Find the middle point between the first and last ticket
                $middleIndex = floor($waitingTickets->count() / 2);
                $prevTicket = $waitingTickets[$middleIndex - 1];
                $nextTicket = $waitingTickets[$middleIndex];
    
                // Add 3 seconds to the time between the previous and next ticket to place it in the middle
                $currentTicket->created_at = $prevTicket->created_at->diffInSeconds($nextTicket->created_at) < 3 
                    ? $prevTicket->created_at->addSeconds(3) // Ensure there's at least 3 seconds between them
                    : $prevTicket->created_at->addSeconds(1);
            }
            else {
                // If there's only one ticket in the queue, we can just add a 3 second delay after it
                $currentTicket->created_at = $waitingTickets->first()->created_at->addSeconds(3);
            }
    
            // Save the updated skipped ticket
            $currentTicket->save();
        }
    
        // Find the next waiting ticket and promote it to 'serving'
        $nextTicket = Visitor::where('status', 'waiting')->where('department', 'clinic')->orderBy('created_at', 'asc')->first();
        if ($nextTicket) {
            $nextTicket->status = 'serving';
            $nextTicket->save();
        }
    
        // Fetch updated queue data
        $queueData = Visitor::where('department', 'clinic')
                            ->where('status', 'waiting')
                            ->orderBy('created_at', 'asc')
                            ->get();
    
        return response()->json([
            'currentServing' => $nextTicket, // Provide the new serving ticket
            'queueData' => $queueData,       // Updated queue list
            'message' => 'Ticket skipped successfully, and the next ticket is now serving.'
        ]);
    }
}
