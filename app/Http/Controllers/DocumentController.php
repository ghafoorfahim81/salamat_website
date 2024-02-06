<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Deadline;
use App\Models\DeadlineType;
use App\Models\Directorate;
use App\Models\DocType;
use App\Models\Document;
use App\Models\Employee;
use App\Models\FollowupType;
use App\Models\SecurityLevel;
use App\Models\Status;
use App\Models\Tracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function index(Request $request)
    {
//        $x = DTSController::getArchiveData();
//        dd('hi',$x);
         if ($request->ajax()) {
            return (new Document)->getDocuments($request);
        }
        return view('documents.index');
    }

    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>  '400',
                'message' => __('general_words.missing_inputs'),
                'errors'=> $validator->messages()
            ]);
        }else{
            $document = new Document();
            $document->title = $request->input('title');
            $document->subject = $request->input('subject');
            $document->remark = $request->input('remark');
            $document->created_by = auth()->user()->id;
            $document->save();
            return response()->json([
                'status' => 200,
                'document_id'=>$document->id,
                'message' => __('general_words.record_saved'),
            ]);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
//        $data['firstTracker']= (new Tracker())->documentTrackers($document->id)->first();
        $data['trackers'] = (new Tracker())->documentTrackers($document->id);
        $data['latestFlow']  = DB::table('documents')->selectRaw('ReturnLastFormFlow("document_flows",'.$document->id.') as flow')->value('flow');
        $data['document'] = Document::where('id',$document->id)->with('user')->first();
        return view('documents.show', $data);
    }

    public function details(Document $document)
    {
        $data['firstTracker'] = (new Tracker())->documentTrackers($document->id)->first();
        $data['trackers'] = (new Tracker())->documentTrackers($document->id);
        $data['latestFlow'] = DB::table('documents')->selectRaw('ReturnLastFormFlow("document_flows",' . $document->id . ') as flow')->value('flow');
        $data['document'] = $document;

        return view('documents.details', $data);
    }


    public function printReceipt($id)
    {
        $data['tracker'] = (new Tracker())->printReceipt($id);
        $employee  = Employee::where('id',$data['tracker']->senderId)->first();
        $data['level1']    = Directorate::where('id',$employee->directorate_id)->first(['name_'.\App::getLocale(),'parent_id']);
        $data['level2']    = Directorate::where('id',$data['level1']->parent_id)->first(['name_'.\App::getLocale(),'parent_id']);
        $data['level3']    = Directorate::where('id',$data['level2']->parent_id)->first('name_'.\App::getLocale());
        return view('documents.print-receipt', $data);
    }

    public function edit(Document $document)
    {
        $data['document'] = $document;
        return view('documents.edit', $data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $document)
    {
        // return $request->type;
        $documentId  = Document::find($document);
        $documentId->update([
            'remark' =>$request->remark,
            'subject' => $request->subject,
            'title' => $request->title,
        ]);
        return response()->json([
            'status' => '200',
            'message' => __('general_words.record_updated')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        $deleted = $document->delete();
        if ($deleted) {
            return response()->json([
                'status' => '200',
                'message' => __('general_words.record_deleted'),
            ]);
        }
    }

}
