<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SurveyResponse;
use App\Models\Administrators;

class FeedbackController extends Controller
{
    public function getFeedback(Request $request)
    {
        $query = SurveyResponse::query();
        if ($request->has('client_type') && $request->client_type != '') {
            $query->where('client_type', $request->client_type);
        }
        if ($request->has('gender') && $request->gender != '') {
            $query->where('Gender', $request->gender);
        }
        if ($request->has('office') && $request->office != '') {
            $query->where('Office', 'LIKE', '%' . $request->office . '%');
        }
        if ($request->has('service') && $request->service != '') {
            $query->where('Service', 'LIKE', '%' . $request->service . '%');
        }
        $feedbacks = $query->get([
            'Office',
            'Service',
            'SQD_0',
            'SQD_1',
            'SQD_2',
            'SQD_3',
            'SQD_4',
            'SQD_5',
            'SQD_6',
            'SQD_7',
            'Feedback',
            'created_at'
        ]);
        return response()->json($feedbacks);
    }
    public function show()
    {
        $preparedBy = Administrators::where('position', 'Administrative Aide III')->first();
        $reviewedBy = Administrators::where('position', 'Administrative Officer IV')->first();
        $notedBy = Administrators::where('position', 'Principal IV')->first();
        if (!$preparedBy || !$reviewedBy || !$notedBy) {
            // You could also log an error here if it's important to know when these records are missing
        }
        return view('super-admin.reports.printEx', compact('preparedBy', 'reviewedBy', 'notedBy'));
    }
    public function show1()
    {
        $preparedBy = Administrators::where('position', 'Administrative Aide III')->first();
        $reviewedBy = Administrators::where('position', 'Administrative Officer IV')->first();
        $notedBy = Administrators::where('position', 'Principal IV')->first();
        if (!$preparedBy || !$reviewedBy || !$notedBy) {
            // You could also log an error here if it's important to know when these records are missing
        }
        return view('records.reports.printEx', compact('preparedBy', 'reviewedBy', 'notedBy'));
    }

    public function show2()
    {
        $preparedBy = Administrators::where('position', 'Administrative Aide III')->first();
        $reviewedBy = Administrators::where('position', 'Administrative Officer IV')->first();
        $notedBy = Administrators::where('position', 'Principal IV')->first();
        if (!$preparedBy || !$reviewedBy || !$notedBy) {
            // You could also log an error here if it's important to know when these records are missing
        }
        return view('admin.reports.printEx', compact('preparedBy', 'reviewedBy', 'notedBy'));
    }

    public function show3()
    {
        $preparedBy = Administrators::where('position', 'Administrative Aide III')->first();
        $reviewedBy = Administrators::where('position', 'Administrative Officer IV')->first();
        $notedBy = Administrators::where('position', 'Principal IV')->first();
        if (!$preparedBy || !$reviewedBy || !$notedBy) {
            // You could also log an error here if it's important to know when these records are missing
        }
        return view('accounting.reports.printEx', compact('preparedBy', 'reviewedBy', 'notedBy'));
    }

    public function show4()
    {
        $preparedBy = Administrators::where('position', 'Administrative Aide III')->first();
        $reviewedBy = Administrators::where('position', 'Administrative Officer IV')->first();
        $notedBy = Administrators::where('position', 'Principal IV')->first();
        if (!$preparedBy || !$reviewedBy || !$notedBy) {
            // You could also log an error here if it's important to know when these records are missing
        }
        return view('guidance.reports.printEx', compact('preparedBy', 'reviewedBy', 'notedBy'));
    }

    public function show5()
    {
        $preparedBy = Administrators::where('position', 'Administrative Aide III')->first();
        $reviewedBy = Administrators::where('position', 'Administrative Officer IV')->first();
        $notedBy = Administrators::where('position', 'Principal IV')->first();
        if (!$preparedBy || !$reviewedBy || !$notedBy) {
            // You could also log an error here if it's important to know when these records are missing
        }
        return view('clinic.reports.printEx', compact('preparedBy', 'reviewedBy', 'notedBy'));
    }
}
