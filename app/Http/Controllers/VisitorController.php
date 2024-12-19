<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Carbon\Carbon;

class VisitorController extends Controller
{
    // For super-admin transaction report
    public function index(Request $request)
    {
        $query = Visitor::query();
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->has('department')) {
            $query->where('department', 'like', '%' . $request->input('department') . '%');
        }
        return response()->json($query->get());
    }

    // For principal transaction report
    public function indexes(Request $request)
    {
        $query = Visitor::query();
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->has('department')) {
            $query->where('department', 'like', '%' . $request->input('department') . '%');
        }
        return response()->json($query->get());
    } 

    // For admin transaction report
    public function index2(Request $request)
    {
        $query = Visitor::query();
        
        // Filter by start_date if provided
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        // Filter by end_date if provided
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        // Explicitly filter by the "Admin" department
        $query->where('department', 'Admin');
    
        return response()->json($query->get());
    }

    // For Accounting transaction report
    public function index3(Request $request)
    {
        $query = Visitor::query();
        
        // Filter by start_date if provided
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        // Filter by end_date if provided
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        // Explicitly filter by the "Admin" department
        $query->where('department', 'Accounting');
    
        return response()->json($query->get());
    }

    // For Clinic transaction report
    public function index4(Request $request)
    {
        $query = Visitor::query();
        
        // Filter by start_date if provided
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        // Filter by end_date if provided
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        // Explicitly filter by the "Admin" department
        $query->where('department', 'Clinic');
    
        return response()->json($query->get());
    }

    // For Guidance transaction report
    public function index5(Request $request)
    {
        $query = Visitor::query();
        
        // Filter by start_date if provided
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        // Filter by end_date if provided
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        // Explicitly filter by the "Admin" department
        $query->where('department', 'Guidance');
    
        return response()->json($query->get());
    }

    // For Records transaction report
    public function index6(Request $request)
    {
        $query = Visitor::query();
        
        // Filter by start_date if provided
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        // Filter by end_date if provided
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        // Explicitly filter by the "Admin" department
        $query->where('department', 'Records');
    
        return response()->json($query->get());
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|numeric',
            'department' => 'required|string|max:255',
            'purpose' => 'nullable|string|max:255',
        ]);
        $ticketNumber = $this->generateTicketNumber($validatedData['department']);
        $validatedData['ticket_number'] = $ticketNumber;
        $visitor = Visitor::create($validatedData);
        session()->flash('ticketNumber', $ticketNumber);
        session()->save();
        return response()->json([
            'success' => true,
            'ticket_number' => $ticketNumber
        ]);
    }

    // Function to generate a queueing ticket number
    private function generateTicketNumber($department)
    {
        // Determine the ticket prefix based on the department
        switch ($department) {
            case 'Records':
                $prefix = 'REC' ;
                break;
            case 'Accounting':
                $prefix = 'ACC' ;
                break;
            case 'Admin':
                $prefix = 'ADM' ;
                break;
            case 'Guidance':
                $prefix = 'GUI' ;
                break;
            case 'Clinic':
                $prefix = 'MED' ;
                break;
            default:
                $prefix = 'TKT' ; // Default prefix if department not specified
                break;
        }

        // Get the latest ticket number for the department for the current day
        $latestTicket = Visitor::where('department', $department)
            ->whereDate('created_at', Carbon::today()) // Ensure it's for today
            ->latest()
            ->value('ticket_number');

        // If there are no existing tickets for the day, start with 1
        if (!$latestTicket) {
            return $prefix . '-001';
        }

        // Extract the numeric part of the latest ticket number
        $latestNumber = intval(substr($latestTicket, strrpos($latestTicket, '-') + 1));

        // Increment the number and append it to the department prefix
        $newNumber = $latestNumber + 1;

        // Ensure the new number is formatted with leading zeros
        $newNumberPadded = str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        return $prefix . '-' . $newNumberPadded;
    }
        // Function to convert a string into datetime
    private function convertToDatetime($string)
    {
        // Assuming the format '002024' corresponds to 'YYMMDD' 
        // Adjust the logic according to your actual date format
        $year = substr($string, 0, 2);
        $month = substr($string, 2, 2);
        $day = substr($string, 4, 2);
        return Carbon::createFromFormat('y-m-d', $year . '-' . $month . '-' . $day)->toDateString();
    }

    // Function to print visitor details
    private function printVisitorDetails($data)
    {
        // Specify the file path for the printer
        $printerFile = '/dev/usb/lp0'; // Example path for a USB thermal printer
        try {
            // Initialize the printer connector
            $connector = new FilePrintConnector($printerFile);

            // Initialize the printer
            $printer = new Printer($connector);

            // Print visitor details in a compact format
            $printer->text("Queueing Ticket:\n");
            $printer->text("Name: " . $data['name'] . "\n");
            $printer->text("Department: " . $data['department'] . "\n");
            $printer->text("Ticket Number: " . $data['ticket_number'] . "\n");

            // Cut the paper
            $printer->cut();

            // Close the printer
            $printer->close();
        } catch (\Exception $e) {
            // Handle any exceptions, e.g., printer not available
            \Log::error('Printing error: ' . $e->getMessage());
        }
    }
        public function showDashboard()
    {
        $user = auth()->user();
        $isSuperadmin = $user->hasRole('superadmin'); // Assuming you use Spatie roles

        return view('accounting/dashboard', compact('isSuperadmin'));
    }

    // Department Transaction History
    public function showAccountingVisitors()
    {
        $recentTransactions = Visitor::where('department', 'accounting')
        ->latest()
        ->take(5) // Fetch the 5 most recent transactions
        ->get();    
        $accountingVisitors = Visitor::where('department', 'accounting')
        ->orderBy('created_at', 'desc')
        ->get();
        if ($accountingVisitors->count() > 5) {
            $accountingVisitors->shift(); // Removes the first (oldest) visitor
        }
        return view('accounting.TransactionHistory', compact('recentTransactions', 'accountingVisitors'));
    }
    public function showAdminVisitors()
    {
        $recentTransactions = Visitor::where('department', 'admin')
        ->latest()
        ->take(5) // Fetch the 5 most recent transactions
        ->get();    
        $adminVisitors = Visitor::where('department', 'admin')
        ->orderBy('created_at', 'desc')
        ->get();
        if ($adminVisitors->count() > 5) {
            $adminVisitors->shift(); // Removes the first (oldest) visitor
        }
        return view('admin.TransactionHistory', compact('recentTransactions', 'adminVisitors'));
    }
    public function showClinicVisitors()
    {
        $recentTransactions = Visitor::where('department', 'clinic')
        ->latest()
        ->take(5) // Fetch the 5 most recent transactions
        ->get();    
        $clinicVisitors = Visitor::where('department', 'clinic')
        ->orderBy('created_at', 'desc')
        ->get();
        if ($clinicVisitors->count() > 5) {
            $clinicVisitors->shift(); // Removes the first (oldest) visitor
        }
        return view('clinic.TransactionHistory', compact('recentTransactions', 'clinicVisitors'));
    }
    public function showGuidanceVisitors()
    {
        $recentTransactions = Visitor::where('department', 'guidance')
        ->latest()
        ->take(5) // Fetch the 5 most recent transactions
        ->get();    
        $guidanceVisitors = Visitor::where('department', 'guidance')
        ->orderBy('created_at', 'desc')
        ->get();
        if ($guidanceVisitors->count() > 5) {
            $guidanceVisitors->shift(); // Removes the first (oldest) visitor
        }
        return view('guidance.TransactionHistory', compact('recentTransactions', 'guidanceVisitors'));
    }
    public function showRecordsVisitors()
    {
        $recentTransactions = Visitor::where('department', 'records')
        ->latest()
        ->take(5) // Fetch the 5 most recent transactions
        ->get();    
        $recordsVisitors = Visitor::where('department', 'records')
        ->orderBy('created_at', 'desc')
        ->get();
        if ($recordsVisitors->count() > 5) {
            $recordsVisitors->shift(); // Removes the first (oldest) visitor
        }
        return view('records.TransactionHistory', compact('recentTransactions', 'recordsVisitors'));
    }


    public function cancelTicket(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'reason' => 'required|string|max:255',  // Reason is required
            'ticket_id' => 'required|exists:visitors,id',  // Ensure the ticket exists
        ]);
    
        // Start a database transaction
        \DB::beginTransaction();
    
        try {
            // Find the visitor by ID
            $visitor = Visitor::find($validated['ticket_id']);
    
            // Check if the visitor exists
            if (!$visitor) {
                return response()->json(['error' => 'Ticket not found.'], 404);
            }
    
            // Update the visitor's reason and status to 'canceled'
            $visitor->update([
                'reason' => $validated['reason'],
                'status' => 'canceled',
            ]);
    
            // Handle transitioning tickets in the queue for the 'accounting' department
            if ($visitor->department === 'accounting' && $visitor->status === 'serving') {
                // Find the next ticket to serve
                $nextTicket = Visitor::where('status', 'waiting')
                    ->where('department', 'accounting')
                    ->orderBy('created_at', 'asc')
                    ->first();
    
                if ($nextTicket) {
                    $nextTicket->update(['status' => 'serving']);
                }
            }
    
            // Commit the transaction
            \DB::commit();
    
            // Fetch updated queue data
            $queueData = Visitor::where('status', 'waiting')
                ->where('department', 'accounting')
                ->orderBy('created_at', 'asc')
                ->get();
    
            // Return a success response with the queue data
            return response()->json([
                'queueData' => $queueData,
                'message' => 'Ticket canceled successfully and queue updated.',
            ], 200);
    
        } catch (\Exception $e) {
            // Rollback the transaction on error
            \DB::rollBack();
    
            // Log the error
            \Log::error('Error during ticket cancellation: ' . $e->getMessage());
    
            // Return a failure response
            return response()->json(['error' => 'Failed to cancel the ticket. Please try again later.'], 500);
        }
    }
    
    
}
