<?php

namespace App\Http\Controllers;

use App\Models\Directorate;
use App\Models\DocType;
use App\Models\Document;
use App\Models\Item;
use App\Models\Tracker;
use Illuminate\Support\Facades\DB;
use Mpdf\Tag\Tr;

class DashboardController extends Controller
{
    protected $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function dashboard()
    {

        $tracker = new Tracker();
        $directorId = auth()->user()->directorate_id;
//        dd($directorId);

        $documentsCountByDirectorates = $tracker->getTrackersCountByDirectorate($directorId);
        $documentCountTypes = $tracker->getDocumentCount();
        $dataForSlugs = $tracker->getSuggestion();
        $dataForLetters = $tracker->getLetter();
        $dataForRequisitions = $tracker->getRequisition();
        $saderaAndWareda = DB::table('doc_types')
            ->selectRaw('
        doc_types.name as docType,
        SUM(CASE WHEN trackers.in_num IS NOT NULL THEN 1 ELSE 0 END) as wareda,
        SUM(CASE WHEN trackers.out_num IS NOT NULL THEN 1 ELSE 0 END) as sadera
    ')
            ->leftJoin('trackers', 'doc_types.id', '=', 'trackers.doc_type_id')
            ->groupBy('doc_types.name')
            ->orderBy('doc_types.id', 'asc')
            ->get();

//        dd($saderaAndWared->toArray());

//        dd($dataForRequisitions);
//        $documentsCountByDirectorates =$tracker->getDocumentsCountByDirectorate();
//        dd($documentsCountByDirectorates);

        return view('dashboard', compact('documentCountTypes', 'dataForSlugs', 'saderaAndWareda', 'dataForLetters', 'dataForRequisitions'));
    }

    public function dashBoardData()
    {
        $tracker = new Tracker();
        $todaySentTrackers = $tracker->getTodaySentTrackers();
        $todayTrackers = $tracker->getTodayTrackers();

//        $slugs = (new DocType())::pluck('slug')->toArray();
//        $dataForSlugs = [];
//        foreach ($slugs as $currentSlug) {
//            $dataForSlugs[$currentSlug] = $tracker->getDocumentsBasedOnTypes($currentSlug);
//        }

        //done with
        $topFiveDirectorates = (new Directorate())->topFive();
        $directoratesDocuments = $tracker->getDirectoratesDocuments();
        $directoratesSentDocuments = $tracker->getSentDocuments();
        $documentsCountByDirectorates = $tracker->getDocumentsCountByDirectorate();
        return response()->json([
            'todaySentTrackers' => $todaySentTrackers,
            'todayTrackers' => $todayTrackers,
            'topFiveDirectorates' => $topFiveDirectorates,
            'directoratesDocuments' => $directoratesDocuments,
            'directoratesSentDocuments' => $directoratesSentDocuments,
            'documentsCountByDirectorates' => $documentsCountByDirectorates,
        ]);
    }


}
