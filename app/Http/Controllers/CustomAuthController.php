<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\SurveyResponse;
use App\Models\Visitor;
use Session;

class CustomAuthController extends Controller
{
    public function lobbyMonitor()
    {
        $users = User::all();
        $data = array();
        if(Session::has('loginId')){
            $data = User::where('id', '=', Session::get('loginId'))->first();
        }
        return view('super-admin.view', compact('users', 'data'));
    }
    public function feedback()
    {
        $users = User::all();
        $data = array();
        if(Session::has('loginId')){
            $data = User::where('id', '=', Session::get('loginId'))->first();
        }
        return view('feedback.feedback', compact('users', 'data'));
    }
    public function survey()
    {
        $users = User::all();
        $data = array();
        if(Session::has('loginId')){
            $data = User::where('id', '=', Session::get('loginId'))->first();
        }
        return view('feedback.survey', compact('users', 'data'));
    }

    // survey
    public function storeForm(Request $request)
    {
        $request->validate([
            'Office' => 'nullable|string|',
            'Service' => 'nullable|string|',
            'SQD_0' => 'nullable|string',
            'SQD_1' => 'nullable|string',
            'SQD_2' => 'nullable|string',
            'SQD_3' => 'nullable|string',
            'SQD_4' => 'nullable|string',
            'SQD_5' => 'nullable|string',
            'SQD_6' => 'nullable|string',
            'SQD_7' => 'nullable|string',
            'Feedback' => 'nullable|string|max:1000',
        ]);
        
        $survey = new SurveyResponse();
        $survey->Office = $request->Office;
        $survey->Service = $request->Service;
        $survey->SQD_0 = $request->SQD_0;
        $survey->SQD_1 = $request->SQD_1;
        $survey->SQD_2 = $request->SQD_2;
        $survey->SQD_3 = $request->SQD_3;
        $survey->SQD_4 = $request->SQD_4;
        $survey->SQD_5 = $request->SQD_5;
        $survey->SQD_6 = $request->SQD_6;
        $survey->SQD_7 = $request->SQD_7;
        $survey->Feedback = $request->Feedback;
        $survey->save();
        return redirect()->back()->with('success', 'Survey has been submitted.');
    }


    public function updateStatusToServing(Request $request)
    {
        $ticketId = $request->input('ticket_id');
        $visitor = Visitor::find($ticketId);
        if ($visitor) {
            $visitor->status = 'serving';
            $visitor->save();
            return response()->json(['success' => true, 'message' => 'Status updated to serving']);
        } else {
            return response()->json(['success' => false, 'message' => 'Visitor not found'], 404);
        }
    }
}
