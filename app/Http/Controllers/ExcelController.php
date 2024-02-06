<?php

namespace App\Http\Controllers;

use App\Exports\Fecen9Export;
use App\Exports\GeneralSample;
use App\Models\CardToCard;
use App\Models\Directorate;
use App\Models\Document;
use App\Models\Fecen1;
use App\Models\Fecen4;
use App\Models\Fecen5;
use App\Models\Fecen8;
use App\Models\Fecen9;
use App\Models\Item;
use App\Models\Meem7;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function export(Request $request)
    {
        $report_type      = $request->type;
//        return $report_type
        if ($report_type ==='ranking_report') {
            $data = (new Directorate())->getRankingReportData($request->order_status);
            $collection = collect($data);
            $lenght = count($data);
            $myArray = [];
            $file_name = $request->order_status == 'completed' ? __('report.completed_trackers') : ($request->order_status == 'approved' ? __('report.approved_trackers') : ($request->order_status == 'pending' ? __('report.pending_trackers') : ($request->order_status == 'ongoing' ? __('report.ongoing_trackers') : ($request->order_status == 'rejected' ? __('report.rejected_trackers') : __('report.not_completed_trackers')))));
            $newData = $collection->map(function ($datad, $key) use ($request) {
                $total = $request->order_status === 'completed' ? $datad->completed :
                    ($request->order_status === 'approved' ? $datad->approved :
                        ($request->order_status === 'pending' ? $datad->pending :
                            ($request->order_status === 'ongoing' ? $datad->ongoing :
                                ($request->order_status === 'rejected' ? $datad->rejected :
                                    ($request->order_status === 'not_completed' ? $datad->not_completed : 0)))));


                $myArray = [
                    'no' => ++$key,
                    'directorate' => $datad->directorate,
                    'total' => $total,
                ];
                return $myArray;
            });
            $header = [
                __('general_words.number'),
                __('document.directorate'),
                __('document.total_trackers'),
            ];

            // return $newData;
            $column_size = [7, 40, 25];
            $export = new GeneralSample([$newData], $lenght, '', $header, $column_size,__('report.most').' '. $file_name);
            return Excel::download($export, 'Ranking report.xlsx');
        }

        if($report_type === 'directorate_report'){
            $data = (new Directorate())->getDirectoratesReports($request);
            $collection = collect($data);
            $lenght = count($data);
            $myArray = [];
            $newData = $collection->map(function ($datad, $key) use ($request) {
                $myArray = [
                    'no' => ++$key,
                    'directorate' => $datad->directorate,
                    'doc_type' => $datad->docType,
                    'total' => $datad->total,
                    'receives' => $datad->receives,
                    'sends' => $datad->sends,
                    'completed' => $datad->completed,
                    'approved' => $datad->approved,
                    'pending' => $datad->pending,
                    'ongoing' => $datad->ongoing,
                    'rejected' => $datad->rejected,
                    'not_completed' => $datad->notCompleted,
                ];
                return $myArray;
            });
            $header = [
                __('general_words.number'),
                __('document.directorate'),
                __('document.document_type'),
                __('report.total_trackers'),
                __('report.receives'),
                __('report.sends'),
                __('report.completed_trackers'),
                __('report.approved_trackers'),
                __('report.pending_trackers'),
                __('report.ongoing_trackers'),
                __('report.rejected_trackers'),
                __('report.not_completed_trackers'),
            ];

            // return $newData;
            $column_size = [7, 40, 18, 18, 18, 20, 25, 25, 25, 25,25,25];
            $export = new GeneralSample([$newData], $lenght, '', $header, $column_size,__('report.directorates_report'));
            return Excel::download($export, 'Directorates report.xlsx');
        }
        if($report_type === 'general_report'){
            $data = (new Document())->getGeneralReportData($request);
            $collection = collect($data);
            $lenght = count($data);
            $myArray = [];
            $newData = $collection->map(function ($datad, $key) use ($request) {
                $myArray = [
                    'no' => ++$key,
                    'title' => $datad->title,
                    'docType' => $datad->docType,
                    'docTypeName' => $datad->docTypeName,
                    'sender' => $datad->sender,
                    'receiver' => $datad->receiver,
                    'in_num' => $datad->in_num,
                    'out_num' => $datad->out_num,
                    'in_date' => $datad->in_date,
                    'status' => $datad->status,
                ];
                return $myArray;
            });
            $header = [
                __('general_words.number'),
                __('document.title'),
                __('document.internal_external'),
                __('report.document_type'),
                __('document.sender'),
                __('document.receiver'),
                __('document.in_number'),
                __('document.out_number'),
                __('document.in_date'),
                __('document.document_status'),
            ];

            // return $newData;
            $column_size = [7, 40, 18, 18, 18, 20, 25, 25, 25, 25];
            $export = new GeneralSample([$newData], $lenght, '', $header, $column_size,__('report.directorates_report'));
            return Excel::download($export, 'General Report.xlsx');
        }
    }


}
