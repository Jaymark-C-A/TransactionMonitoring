<?php

namespace App\Http\Controllers;

use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class getSurveyData extends Controller
{
    public function getSurveydata()
    {
        $surveyData = SurveyResponse::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('date')
        ->get();
    return response()->json($surveyData); // Return the data as JSON
    }
}
