<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Carbon\Carbon;

class VisitorController extends Controller
{

    public function index(Request $request)
    {
        $query = Visitor::query();
    
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
    
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
    
        $search = $request->input('query'); // Correctly retrieving the 'query' parameter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('contact', 'LIKE', "%{$search}%")
                  ->orWhere('department', 'LIKE', "%{$search}%")
                  ->orWhere('purpose', 'LIKE', "%{$search}%")
                  ->orWhere('ticket_number', 'LIKE', "%{$search}%")
                  ->orWhere('status', 'LIKE', "%{$search}%");
            });
        }
    
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

        // Generate queueing ticket number
        $ticketNumber = $this->generateTicketNumber($validatedData['department']);

        // Add ticket number to validated data
        $validatedData['ticket_number'] = $ticketNumber;

        // Store visitor data in the database
        Visitor::create($validatedData);

        // Print the visitor details
        $this->printVisitorDetails($validatedData);

        return redirect()->back()->with('success', 'Visitor data saved successfully!');
    }

    // Function to generate a queueing ticket number
    private function generateTicketNumber($department)
    {
        // Determine the ticket prefix based on the department
        switch ($department) {
            case 'Records':
                $prefix = 'REC' . Carbon::now()->format('mdy');
                break;
            case 'Accounting':
                $prefix = 'ACC' . Carbon::now()->format('mdy');
                break;
            case 'Admin':
                $prefix = 'ADM' . Carbon::now()->format('mdy');
                break;
            case 'Department_Head':
                $prefix = 'DEP' . Carbon::now()->format('mdy');
                break;
            case 'Principal':
                $prefix = 'PRC' . Carbon::now()->format('mdy');
                break;
            default:
                $prefix = 'TKT' . Carbon::now()->format('ymd'); // Default prefix if department not specified
                break;
        }
    
        // Get the latest ticket number for the department from the database
        $latestTicket = Visitor::where('department', $department)->latest()->value('ticket_number');
    
        // If there are no existing tickets for the department, start with 1
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
            $printer->text("Queuing Ticket:\n");
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
}
