<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SurveyResponse;

class SurveyController extends Controller
{
    public function getSurveyData(Request $request)
    {
        $period = $request->query('period', 'daily'); // Default to 'daily'
        switch ($period) {
            case 'weekly':
                $groupBy = 'WEEK(created_at)';
                break;
            case 'monthly':
                $groupBy = 'MONTH(created_at)';
                break;
            case 'yearly':
                $groupBy = 'YEAR(created_at)';
                break;
            default:
                $groupBy = 'DATE(created_at)';
                break;
        }
        $surveyData = SurveyResponse::select(DB::raw($groupBy . ' as period'), DB::raw('count(*) as total'))
            ->groupBy('period')
            ->orderBy('period')
            ->get();
        return response()->json($surveyData);
    }
    public function getSurveyCount(Request $request)
    {
        $period = $request->query('period', 'daily');
        switch ($period) {
            case 'weekly':
                $groupBy = 'WEEK(created_at)';
                break;
            case 'monthly':
                $groupBy = 'MONTH(created_at)';
                break;
            case 'yearly':
                $groupBy = 'YEAR(created_at)';
                break;
            default:
                $groupBy = 'DATE(created_at)';
                break;
        }
        $surveyCount = SurveyResponse::select(DB::raw($groupBy . ' as period'), DB::raw('count(*) as count'))
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->sum('count');
        return response()->json(['count' => $surveyCount]);
    }
}
