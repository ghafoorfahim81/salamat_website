<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrackerRequest;
use App\Http\Requests\UpdateTrackerRequest;
use App\Http\Resources\TrackerResource;
use App\Models\Attachment;
use App\Models\Directorate;
use App\Models\DocCopy;
use App\Models\Document;
use App\Models\FiscalYears;
use App\Models\Log;
use App\Models\Tracker;
use App\Models\User;
use App\Notifications\AddTrackerNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ActivityAssignedNotification;
use Mpdf\Tag\Tr;

class TrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $tracker;

    public function __construct(Tracker $tracker){
        $this->tracker = $tracker;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return (new Tracker())->getDocumentTrackers($request);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $trackerForm = json_decode($request->form);
        $document_id = $trackerForm->document_id;
        if($trackerForm->title){
            $document = Document::create([
                'title' => $trackerForm->title,
                'created_by' => auth()->id(),
            ]);
            $document_id = $document->id;
        }
        $ccUsers = json_decode($request->ccUsers);
        $ccDirs = json_decode($request->ccDirs);
        $dirUsers = [];
        $tracker = new Tracker();
        $tracker->sender_employee_id = auth()->user()->employee_id;
        $tracker->receiver_employee_id = $trackerForm->receiver_employee_id;
        $tracker->receiver_directorate_id = $trackerForm->receiver_directorate_id;
        $tracker->sender_directorate_id = $trackerForm->external_directorate_id ?? auth()->user()->directorate_id;
        $tracker->out_date = dateToMiladi($trackerForm->out_date);
        $tracker->in_date = dateToMiladi($trackerForm->in_date) ?? null;
        $out_doc_prefix = null;
        $in_doc_prefix = null;
        if($trackerForm->external_directorate_id){
            $out_doc_prefix = null;
        }
        else{
            $sender_directorate  = Directorate::where('id',auth()->user()->directorate_id)->first();
            $out_doc_prefix = $sender_directorate->prefix.'O';
        }
        if ($tracker->in_date) {
            $receiver  = Directorate::where('id',$trackerForm->receiver_directorate_id)->first();
            $in_doc_prefix = $receiver->prefix.'I';
            $tracker->in_num = (new Tracker())->generateIncomingDocNum($trackerForm->receiver_directorate_id, $trackerForm->doc_type_id, dateToMiladi($trackerForm->in_date));
        }
        if ($trackerForm->out_date) {
            $tracker->out_num =(new Tracker())->generateOutgoingDocNum($trackerForm->external_directorate_id ?? auth()->user()->directorate_id, $trackerForm->doc_type_id, dateToMiladi($trackerForm->out_date));
        }
        $tracker->phone_number = $trackerForm->phone_number;
        $tracker->focal_point_name = $trackerForm->focal_point_name;
        $tracker->request_deadline = $trackerForm->request_deadline;
        $tracker->remark = $trackerForm->remark;
        $tracker->out_doc_prefix = $out_doc_prefix ?? null;
        $tracker->in_doc_prefix = $in_doc_prefix ?? null;
        $tracker->attachment_count = $trackerForm->attachment_count;
        $tracker->deadline_id = $trackerForm->deadline_id?? null;
        $tracker->status_id = $trackerForm->status_id;
        $tracker->deadline_type_id = $trackerForm->deadline_type_id;
        $tracker->security_level_id = $trackerForm->security_level_id;
        $tracker->followup_type_id = $trackerForm->followup_type_id;
        $tracker->document_id = $document_id;
        $tracker->doc_type_id = $trackerForm->doc_type_id;
        $tracker->conclusion = $trackerForm->conclusion;
        $tracker->in_out = $trackerForm->in_out ?? null;
        $tracker->type = $trackerForm->type;
        $tracker->is_checked = 0;
        $tracker->decision_subject = $trackerForm->decision_subject;
        $tracker->created_by = auth()->user()->id;
//        dd($tracker);
        $tracker->save();

//        $user = User::where('employee_id', $tracker->receiver_employee_id)->first();
//        $user->notify(new AddTrackerNotification($tracker, $user));

        if ($ccDirs && count($ccDirs) > 0) {
            foreach (array_unique($ccDirs) as $ccDir) {
                $dirUsers = User::where('directorate_id', $ccDir)->pluck('employee_id')->toArray();
            }
            $this->addCcUsers($dirUsers, $tracker->id);
        }
        if ($ccUsers && count($ccUsers) > 0) {
            $this->addCcUsers($ccUsers, $tracker->id);
        }
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fullName = $file->getClientOriginalName();
                $originalName = pathinfo($fullName, PATHINFO_FILENAME);
                $fileExtension = $file->getClientOriginalExtension();
                $timestampedName = $originalName .'.' . $fileExtension;
                $path = $file->storeAs('public/trackers', $timestampedName);

                $store = Attachment::create([
                    'table_id' => $tracker->id,
                    'table_name' => 'trackers',
                    'assign_name' => 'tracker attachment',
                    'original_name' => $originalName,
                    'file' => $timestampedName,
                    'created_by' => auth()->id(),
                ]);
            }
        }
        return response()->json([
            'status' => '200',
            'document_id' => $document_id,
            'tracker' => (new Tracker())->documentTrackers($trackerForm->document_id,$tracker->id),
            'message' => __('general_words.record_saved'),
        ]);

    }


    public function addCcUsers($users, $tracker_id)
    {
        if ($users && count($users) > 0) {
            foreach ($users as $users) {
                $empId = (int)$users;
                DocCopy::create([
                    'tracker_id' => $tracker_id,
                    'emp_id' => $empId,
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tracker $tracker)
    {
        $tracker = $tracker->load(['sender','comments','senderDir','senderExternal', 'receiver','receiverEmp', 'docType', 'deadline', 'deadlineType',
            'followupType', 'securityLevel', 'status']);
        $comments = $this->tracker->trackerComments($tracker->id);
        return ['tracker'=>$tracker, 'comments'=>$comments];

    }

    public function attachments($id)
    {
//        return $id;
        $attachments = Attachment::where('table_id', $id)->where('table_name', 'trackers')->get();
        return $attachments;
    }
    function reloadTrackers($document_id){
        return (new Tracker())->documentTrackers($document_id);
    }
    public function receivers($id)
    {
        return (new Tracker())->getTrackerReceivers($id);
    }

    public function edit(Tracker $tracker)
    {

        $tracker = $tracker->load(['sender', 'receiver','receiverEmp','senderDir', 'docType', 'deadline', 'deadlineType',
            'followupType', 'securityLevel', 'status']);
        return $tracker;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {

        $trackerForm = json_decode($request->form);
//        return $trackerForm;
        $ccUsers = json_decode($request->ccUsers);
        $ccDirs = json_decode($request->ccDirs);
        $dirUsers = [];
        $tracker   = Tracker::find($id);
        $update   = $tracker->update([
            'sender_employee_id' =>auth()->user()->employee_id,
            'sender_directorate_id' =>$trackerForm->external_directorate_id??auth()->user()->directorate_id,
            'receiver_employee_id'  =>$trackerForm->receiver_employee_id,
            'receiver_directorate_id' =>$trackerForm->receiver_directorate_id,
            'in_num' => $trackerForm->in_num,
            'out_num' => $trackerForm->out_num,
            'in_date' => $trackerForm->in_date,
            'out_date' => $trackerForm->out_date,
            'phone_number' => $trackerForm->phone_number,
            'focal_point_name' => $trackerForm->focal_point_name,
            'request_deadline' => $trackerForm->request_deadline,
            'remark' =>$trackerForm->remark,
            'attachment_count' => $trackerForm->attachment_count,
            'deadline_id' => $trackerForm->deadline_id,
            'status_id' => $trackerForm->status_id,
            'deadline_type_id' => $trackerForm->deadline_type_id,
            'security_level_id' => $trackerForm->security_level_id,
            'followup_type_id' => $trackerForm->followup_type_id,
            'document_id' => $trackerForm->document_id,
            'doc_type_id' => $trackerForm->doc_type_id,
            'conclusion' => $trackerForm->conclusion,
            'in_out'    => $trackerForm->in_out ?? null,
            'type'      => $trackerForm->type,
            'decision_subject' => $trackerForm->decision_subject,
        ]);
        if ($ccDirs && count($ccDirs) > 0) {
            $tracker->docCopy()->delete();
            foreach (array_unique($ccDirs) as $ccDir) {
                $dirUsers = User::where('directorate_id', $ccDir)->pluck('employee_id')->toArray();
            }
            $this->addCcUsers($dirUsers, $tracker->id);
        }
        if ($ccUsers && count($ccUsers) > 0) {
            $tracker->docCopy()->delete();
            $this->addCcUsers($ccUsers, $tracker->id);
        }

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fullName = $file->getClientOriginalName();
                $originalName = pathinfo($fullName, PATHINFO_FILENAME);
                $fileExtension = $file->getClientOriginalExtension();
                $timestampedName = $originalName .'.' . $fileExtension;
                $path = $file->storeAs('public/trackers', $timestampedName);
                $store = Attachment::create([
                    'table_id' => $tracker->id,
                    'table_name' => 'trackers',
                    'assign_name' => 'tracker attachment',
                    'original_name' => $originalName,
                    'file' => $timestampedName,
                    'created_by' => auth()->id(),
                ]);
            }
        }
        return response()->json([
            'status' => 200,
            'message' => __('general_words.record_updated'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tracker $tracker)
    {
        $deleted = $tracker->delete();
        if($deleted){
            return response()->json([
                'status' => '200',
                'message' => 'Tracker deleted successfully'
            ]);
        }
    }

    public function updateIsChecked(Request $request, $id)
    {
        $tracker = (new Tracker())::findorFail($id);
        $today_date = Carbon::now()->format('Y-m-d');
        $receiver  = Directorate::where('id',$tracker->receiver_directorate_id)->first();
        $in_doc_prefix = $receiver?$receiver->prefix.'I':null;
        $tracker->in_doc_prefix = $in_doc_prefix;
        $tracker->in_date = $today_date;
        $tracker->in_num = (new Tracker())->generateIncomingDocNum($tracker->external_directorate_id ?? auth()->user()->directorate_id, $tracker->doc_type_id,$today_date );
        $tracker->is_checked_date = Carbon::now();
        $tracker->update(['is_checked' => 1]);
        return response()->json(['message' => 'Checkbox status updated successfully', 'status' => 200]);
    }

    public function updateStatus(Request $request, $id)
    {
        $tracker = (new Tracker())::findorFail($id);
        $tracker->update(['status_id' => 4]);
        return response()->json(['message' => 'Status updated successfully', 'status' => 200]);
    }
}

