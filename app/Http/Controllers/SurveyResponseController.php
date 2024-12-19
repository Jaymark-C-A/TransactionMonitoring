<?php
namespace App\Http\Controllers;

use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SurveyResponseController extends Controller
{
    public function filterSurveyResponses(Request $request)
    {
        // Get the start and end dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Validate the dates (optional)
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
    
        // Apply the filter to get the responses for the specific office and within the date range
        $responses = SurveyResponse::where('Office', 'Emis/Records')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
    
        // Do whatever processing you need with the filtered responses, e.g., calculate percentages, counts, etc.
        $totalResponses = $responses->count();
        $totalVisitors = SurveyResponse::where('Office', 'Emis/Records')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->distinct('id')
            ->count('id');
    
        // Return the response (can be in JSON format if you want to update parts of the page dynamically)
        return response()->json([
            'totalResponses' => $totalResponses,
            'totalVisitors' => $totalVisitors,
            'responses' => $responses // Optional: you can return the filtered responses if needed
        ]);
    }
    
    
}