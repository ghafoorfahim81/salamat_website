<?php

namespace App\Http\Controllers;

use App\Models\Directorate;
use App\Models\Document;
use App\Models\Tracker;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    protected $tracker;
    public function __construct(Tracker $tracker){
        $this->tracker = $tracker;
        }
    public function report(Request $request)
    {
        return view('reports.report');
    }

//    this function returns the directorates report data
    public function getReportData(Request $request)
    {
        $type  = $request->type;
        if($type === 'directorates_report')
        {
            return (new Directorate())->getDirectoratesReports($request);
        }

        if($type === 'general_report')
        {
            return (new Document())->getGeneralReportData($request);
        }

        if($type === 'ranking_report')
        {
            return (new Directorate())->getRankingReportData($request->order_status);
        }
    }
}
