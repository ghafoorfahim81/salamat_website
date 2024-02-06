<?php

namespace App\Models;

use http\QueryString;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;


class Tracker extends Model
{
    use softDeletes;
    use HasFactory;

    protected function outDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => miladiToHijriOrJalali($value),
            set: fn ($value) => strpos($value, '-') ? $value : dateToMiladi($value),
        );
    }
    // protected function createdAt(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => miladiToHijriOrJalali($value),
    //         set: fn ($value) => strpos($value, '-') ? $value : dateToMiladi($value),
    //     );
    // }
    protected function inDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => miladiToHijriOrJalali($value),
            set: fn ($value) => strpos($value, '-') ? $value : dateToMiladi($value),
        );
    }

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'sender_employee_id',
        'sender_directorate_id',
        'receiver_employee_id',
        'receiver_directorate_id',
        'in_num',
        'id',
        'out_num',
        'in_date',
        'in_doc_prefix',
        'out_doc_prefix',
        'out_date',
        'phone_number',
        'request_deadline',
        'remark',
        'attachment_count',
        'deadline_id',
        'status_id',
        'deadline_type_id',
        'security_level_id',
        'followup_type_id',
        'document_id',
        'doc_type_id',
        'mobile_number',
        'focal_point_name',
        'decision_subject',
        'conclusion',
        'in_out',
        'type',
        'is_checked',
    ];

    // BelongsTo tables
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function sender(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'sender_employee_id');
    }

    public function receiver(): BelongsTo
    {
        $localeColumn = "name_" . app()->getLocale();
        return $this->belongsTo(Directorate::class, 'receiver_directorate_id')->select(['id', $localeColumn . ' as name']);
    }
    public function senderDir(): BelongsTo
    {
        $localeColumn = "name_" . app()->getLocale();
        return $this->belongsTo(Directorate::class, 'sender_directorate_id')->select(['id', $localeColumn . ' as name']);
    }
    public function senderExternal(): BelongsTo
    {
        return $this->belongsTo(ExternalDirectorate::class, 'sender_directorate_id')->select(['id', 'name']);
    }


    public function receiverEmp(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'receiver_employee_id');
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function docType(): BelongsTo
    {
        return $this->belongsTo(DocType::class);
    }

    public function followupType(): BelongsTo
    {
        return $this->belongsTo(FollowupType::class);
    }

    public function securityLevel(): BelongsTo
    {
        return $this->belongsTo(SecurityLevel::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function deadlineType(): BelongsTo
    {
        return $this->belongsTo(DeadlineType::class);
    }

    public function deadline(): BelongsTo
    {
        return $this->belongsTo(Deadline::class);
    }

    // HasMany tables
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachments::class);
    }

    public function docCopy(): HasMany
    {
        return $this->hasMany(DocCopy::class);
    }
   protected function createdAt(): Attribute
   {
       return Attribute::make(
           get: fn ($value) => miladiToHijriOrJalali($value),
           set: fn ($value) => strpos($value, '-') ? $value : dateToMiladi($value),
       );
   }
//      this function get all teh trackers for a specific document
    public function getDocumentTrackers($request)
    {
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');
        $query = $this
            ->leftjoin('employees', 'employees.id', 'sender_employee_id')
            ->join('documents', 'documents.id', 'document_id')
            ->leftjoin('deadlines', 'deadlines.id', 'deadline_id')
//            ->leftjoin('doc_types', 'doc_types.id', 'deadline_type_id')
            ->join('doc_types', 'trackers.doc_type_id', '=', 'doc_types.id')
            ->leftJoin('directorates as receiverDir', 'receiverDir.id', 'receiver_directorate_id')
            ->leftJoin('directorates as senderDir', 'senderDir.id', 'sender_directorate_id')
            ->selectRaw('
                CASE
                    WHEN trackers.type = "external" THEN external_sender.name
                    ELSE directorate_sender.name_' . lang() . '
                END as sender,
                receiverDir.name_' . lang() . ' as receiver,
                trackers.*,
                deadlines.days as deadline_days,
                doc_types.name as doc_type_name,
                trackers.out_doc_prefix,
                trackers.in_doc_prefix,
                trackers.id as id,
                trackers.created_at as tracker_created_at'
            )

            ->where('document_id', $request->document_id);

        $query->leftJoin('external_directorates as external_sender', function ($join) {
            $join->on('external_sender.id', '=', 'sender_directorate_id')
                ->where('trackers.type', 'external');
        });

        // Left join with directorates for internal documents
        $query->leftJoin('directorates as directorate_sender', function ($join) {
            $join->on('directorate_sender.id', '=', 'sender_directorate_id')
                ->where('trackers.type', 'internal');
        });

        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }
        if ($filter != '') {
            $query = $query->where('fecen9s.fecen9_number', 'like', '%' . $filter . '%');
        }

        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });
        $query = $query->paginate($per_page);
//        foreach ($query as $inDate) {
//            $inDate->in_date = miladiToHijriOrJalali($inDate->in_date);
//        }
        return $query;
    }

//    this function returns one tracker with all the information
    function  getTracking($tracker_id,$document_id = null) {
            $query = $this
                ->leftjoin('employees', 'employees.id', 'sender_employee_id')
                ->join('documents', 'documents.id', 'document_id')
                ->leftjoin('deadlines', 'deadlines.id', 'deadline_id')
//            ->leftjoin('doc_types', 'doc_types.id', 'deadline_type_id')
                ->join('doc_types', 'trackers.doc_type_id', '=', 'doc_types.id')
                ->leftJoin('directorates as receiverDir', 'receiverDir.id', 'receiver_directorate_id')
                ->leftJoin('directorates as senderDir', 'senderDir.id', 'sender_directorate_id')
                ->selectRaw('
                CASE
                    WHEN trackers.type = "external" THEN external_sender.name
                    ELSE directorate_sender.name_' . lang() . '
                END as sender,
                receiverDir.name_' . lang() . ' as receiver,
                trackers.*,
                deadlines.days as deadline_days,
                doc_types.name as doc_type_name,
                receiverDir.prefix as receiver_prefix,
                directorate_sender.prefix as sender_prefix,
                trackers.id as id,
                trackers.created_at as tracker_created_at'
                )

                ->where('document_id', $document_id)
                ->where('trackers.id', $tracker_id);

            $query->leftJoin('external_directorates as external_sender', function ($join) {
                $join->on('external_sender.id', '=', 'sender_directorate_id')
                    ->where('trackers.type', 'external');
            });

            // Left join with directorates for internal documents
            $query->leftJoin('directorates as directorate_sender', function ($join) {
                $join->on('directorate_sender.id', '=', 'sender_directorate_id')
                    ->where('trackers.type', 'internal');
            });
            return $query->first();
        }

//    show a document tracker

    function printReceipt($document_id = null)
    {
        $query = $this
            ->leftJoin('employees', 'employees.id', 'sender_employee_id')
            ->leftJoin('employees as receiver', 'receiver.id', 'receiver_employee_id')
            ->leftJoin('documents', 'documents.id', 'document_id')
            ->leftJoin('deadlines', 'deadlines.id', 'deadline_id')
            ->leftJoin('users', 'users.id', 'documents.created_by')
            ->leftJoin('doc_types', 'trackers.doc_type_id', '=', 'doc_types.id')
            ->leftJoin('directorates as receiverDir', 'receiverDir.id', 'receiver_directorate_id')
            ->leftJoin('directorates as senderDir', 'senderDir.id', 'sender_directorate_id')
            ->leftJoin('external_directorates as external_sender', function ($join) {
                $join->on('external_sender.id', '=', 'sender_directorate_id')
                    ->where('trackers.type', 'external');
            })
            ->selectRaw('
            CASE
                WHEN trackers.type = "external" THEN external_sender.name
                ELSE senderDir.name_' . lang() . '
            END as sender,
            receiverDir.name_' . lang() . ' as receiver,
            trackers.*,
            users.user_name as user,
            documents.title,
            employees.name as senderEmp,
            employees.id as senderId,
            deadlines.days as deadline_days,
            doc_types.name as doc_type_name,
            receiverDir.prefix as receiver_prefix,
            senderDir.prefix as sender_prefix,
            trackers.created_at as tracker_created_at'
            )
            ->where('document_id', $document_id)
            ->orderBy('trackers.id', 'desc')
            ->first();

        return $query;
    }


//    show a document tracker
    public function documentTrackers($document_id = null, $tracker_id = null)
    {
        $query = $this
            ->leftjoin('employees', 'employees.id', 'sender_employee_id')
            ->join('documents', 'documents.id', 'document_id')
            ->leftjoin('doc_types', 'doc_types.id', 'deadline_type_id')
            ->leftjoin('doc_copies', 'tracker_id', 'trackers.id')
            ->leftjoin('users', 'users.id', 'documents.created_by')
            ->leftJoin('directorates as receiverDir', 'receiverDir.id', 'receiver_directorate_id')
            ->selectRaw('
             CASE
            WHEN trackers.type = "external" THEN external_sender.name
            ELSE directorate_sender.name_' . lang() . '
                END as sender,
                receiverDir.name_' . lang() . ' as receiver,
                trackers.type as document_type,
                trackers.*,
                count(doc_copies.id) as doc_copies_count,
                trackers.created_at as tracker_created_at,
                users.user_name as user,
                trackers.id as id'

            )
            ->groupBy('trackers.id')
            ->where('document_id', $document_id);
        $query->leftJoin('external_directorates as external_sender', function ($join) {
            $join->on('external_sender.id', '=', 'sender_directorate_id')
                ->where('trackers.type', 'external');
        });
        $query->leftJoin('directorates as directorate_sender', function ($join) {
            $join->on('directorate_sender.id', '=', 'sender_directorate_id')
                ->where('trackers.type', 'internal');
        });
        if ($tracker_id != null) {
            $query->where('trackers.id', $tracker_id)->first();
        }
        return $query
            ->orderBy('trackers.created_at', 'desc')
            ->get();
    }

//    comment function for trackers
    public function trackerComments($tracker_id){
        return Comment::where('tracker_id', $tracker_id)
            ->whereNull('parent_id')
            ->selectRaw('comments.*')
            ->with('user')
            ->with('replies')
            ->with('attachment')
            ->orderBy('comments.created_at','desc')
            ->get();
    }



    //count of Sent trackers created toDay
    public function getTodaySentTrackers(){
        $query = $this::select(
            DB::raw('DATE(trackers.created_at) as date'),
            'directorates.name_prs as department_name',
            DB::raw('COUNT(*) as document_count')
        )
            ->join('directorates', 'trackers.sender_directorate_id', '=', 'directorates.id')
            ->whereDate('trackers.created_at', now()->toDateString()) // Filter by today's date
            ->groupBy('date', 'trackers.sender_directorate_id'); // Group only by date
        return $query->get();
    }




    //count of today's trackers
    public function getTodayTrackers(){
        $query =  (new Tracker())::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as document_count')
        )
            ->whereDate('created_at', today()) // filter toDaysTrackers
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'));
        return $query->get();
    }

    public function   getSuggestion()
    {
        $query = self::selectRaw('security_levels.id as security_level_id, doc_types.slug, security_levels.name, doc_types.name as documentTypeName, count(*) as total_count, (select count(*) from trackers) as all_trackers_count')
            ->leftJoin('security_levels', 'security_levels.id', 'security_level_id')
            ->leftJoin('doc_types', 'doc_types.id', 'doc_type_id')
            ->whereNull('trackers.deleted_at')
            ->groupBy('security_levels.id', 'security_levels.name', 'doc_types.name')
            ->where('doc_types.slug', 'suggestion');
        return $query->get();
    }

    public function  getLetter()
    {
        $query = self::selectRaw('security_levels.id as security_level_id, doc_types.slug, security_levels.name, doc_types.name as documentTypeName, count(*) as total_count, (select count(*) from trackers) as all_trackers_count')
            ->leftJoin('security_levels', 'security_levels.id', 'security_level_id')
            ->leftJoin('doc_types', 'doc_types.id', 'doc_type_id')
            ->groupBy('security_levels.id', 'security_levels.name', 'doc_types.name')
            ->where('doc_types.slug', 'letter')
            ->whereNull('trackers.deleted_at');

        return $query->get();
    }
    public function  getRequisition()
    {
        $query = self::selectRaw('security_levels.id as security_level_id, doc_types.slug, security_levels.name, doc_types.name as documentTypeName, count(*) as total_count, (select count(*) from trackers) as all_trackers_count')
            ->leftJoin('security_levels', 'security_levels.id', 'security_level_id')
            ->leftJoin('doc_types', 'doc_types.id', 'doc_type_id')
            ->groupBy('security_levels.id', 'security_levels.name', 'doc_types.name')
            ->where('doc_types.slug', 'requisition')
             ->whereNull('trackers.deleted_at');


        return $query->get();
    }


    public function getDocumentCount(){
        $query = (new Tracker())->whereIn('doc_type_id', [1, 2, 3])
            ->groupBy('doc_type_id')
            ->selectRaw('doc_type_id, count(*) as count')
            ->pluck('count', 'doc_type_id');

        return $query->toJson();
    }


    public function getDirectoratesDocuments()
    {
        $chartData = (new Tracker())::join('doc_types', 'trackers.doc_type_id', '=', 'doc_types.id')
            ->join('directorates', 'trackers.receiver_directorate_id', '=', 'directorates.id')
            ->select(
                'directorates.name_prs as directorate',
                'doc_types.name as doc_type',
                DB::raw('count(*) as count')
            )
            ->groupBy('directorates.name_prs', 'doc_types.name', 'trackers.doc_type_id', 'trackers.receiver_directorate_id')
            ->get();

        $transformedData = [];

        foreach ($chartData as $data) {
            $directorate = $data->directorate;
            $docType = $data->doc_type;
            $count = $data->count;

            if (!isset($transformedData[$directorate])) {
                $transformedData[$directorate] = [];
            }

            $transformedData[$directorate][$docType] = $count;
        }

        return $transformedData;
    }

    public function getSentDocuments(){
            $chartData = (new Tracker())::join('doc_types', 'trackers.doc_type_id', '=', 'doc_types.id')
                ->join('directorates', 'trackers.receiver_directorate_id', '=', 'directorates.id')
                ->select(
                    'directorates.name_prs as directorate',
                    DB::raw('count(*) as count')
                )
                ->groupBy('directorates.name_prs', 'trackers.receiver_directorate_id')
                ->get();

            $transformedData = [];

            foreach ($chartData as $data) {
                $directorate = $data->directorate;
                $count = $data->count;

                // Each record is counted for each directorate
                $transformedData[$directorate] = $count;
            }

            return $transformedData;
    }





    public function getDocumentsCountByDirectorate(){
        $chartData = Directorate::leftJoin('trackers as sent_trackers', function($join){
            $join->on('sent_trackers.sender_directorate_id', '=', 'directorates.id')
                ->whereNull('sent_trackers.deleted_at');
        })
            ->leftJoin('trackers as received_trackers', function($join){
                $join->on('received_trackers.receiver_directorate_id', '=', 'directorates.id')
                    ->whereNull('received_trackers.deleted_at');
            })
            ->select(
                'directorates.name_prs as directorate',
                DB::raw('COUNT(DISTINCT sent_trackers.id) as sent_count'),
                DB::raw('COUNT(DISTINCT received_trackers.id) as received_count')
            )
            ->groupBy('directorates.name_prs')
            ->havingRaw('sent_count > 0 OR received_count > 0')
            ->get();

        $transformedData = [];

        foreach ($chartData as $data) {
            $directorate = $data->directorate;
            $transformedData[$directorate] = [
                'receivedTrackers' => $data->received_count,
                'sentTrackers' => $data->sent_count,
            ];
        }

        return $transformedData;
    }





    public function getTrackersCountByDirectorate($directorId)
    {
        $query = (new Tracker())::select(
            'directorates.name_en as directorate_name',
            DB::raw('SUM(CASE WHEN sender_directorate_id = directorates.id THEN 1 ELSE 0 END) as sent_count'),
            DB::raw('SUM(CASE WHEN receiver_directorate_id = directorates.id THEN 1 ELSE 0 END) as received_count')
        )
            ->join('directorates', function ($join) {
                $join->on('trackers.sender_directorate_id', '=', 'directorates.id')
                    ->orOn('trackers.receiver_directorate_id', '=', 'directorates.id');
            })
            ->where('directorates.id', $directorId)
            ->groupBy('directorates.id', 'directorates.name_en')
            ->get();

        return $query;
    }

    function generateOutgoingDocNum($directorateId,$doc_type_id,$date) {
//        dd($directorateId,$date,$docName);

        $year = DB::table('fiscal_years')->where('start_date', '<=', $date)->where('end_date', '>=' ,$date)->first();
//        dd($year);
        $latestOutNum = DB::table('trackers')
            ->where('sender_directorate_id', $directorateId)
            ->where('doc_type_id', $doc_type_id)
            ->where('out_date', '>=', $year->start_date)
            ->where('out_date', '<=', $year->end_date)
            ->max('out_num');
//        dd($latestOutNum);
        return (int) $latestOutNum + 1;
    }

    function generateIncomingDocNum($directorate_id, $doc_type_id,$date) {
        $year = DB::table('fiscal_years')->where('start_date', '<=', $date)->where('end_date', '>=' ,$date)->first();
        $latestInNum = DB::table('trackers')
            ->where('receiver_directorate_id', $directorate_id)
            ->where('doc_type_id', $doc_type_id)
            ->where('in_date', '>=', $year->start_date)
            ->where('in_date', '<=', $year->end_date)
            ->max('in_num');

        return  $latestInNum + 1;
    }

    public function getTrackerReceivers($tracker_id){
        return DB::table('trackers')
            ->join('doc_copies', 'doc_copies.tracker_id', '=', 'trackers.id')
            ->join('employees', 'employees.id', '=', 'doc_copies.emp_id')
            ->join('directorates', 'directorates.id', '=', 'employees.directorate_id')
            ->selectRaw('employees.name as employee_name, directorates.name_prs as directorate_name')
            ->where('doc_copies.tracker_id', $tracker_id)
            ->get();
    }






}
