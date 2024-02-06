<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;


class Document extends Model
{
    use softDeletes;
    use HasFactory;

    protected $dates = ['deleted_at'];
    protected $guarded = ['created'];

    protected $fillable = [
        'title',
        'remark',
        'subject',
        'created_by'
    ];

    public function trackers(): HasMany
    {
        return $this->hasMany(Tracker::class);
    }
    protected function outDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => miladiToHijriOrJalali($value),
            set: fn ($value) => strpos($value, '-') ? $value : dateToMiladi($value),
        );
    }

    protected function getTypeAttribute($value)
    {
        return __('document.types.' . $value);
    }
    protected function inDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => miladiToHijriOrJalali($value),
            set: fn ($value) => strpos($value, '-') ? $value : dateToMiladi($value),
        );
    }
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => miladiToHijriOrJalali($value),
            set: fn ($value) => strpos($value, '-') ? $value : dateToMiladi($value),
        );
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function getDocuments($request)
    {

        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');

        $query = DB::table('documents')
            ->leftJoin('trackers', 'trackers.document_id', '=', 'documents.id')
            ->leftJoin('doc_copies', 'doc_copies.tracker_id', '=', 'trackers.id')
            ->selectRaw('documents.id as documentId, documents.title, documents.subject as documentSubject, documents.remark as documentRemark,
            trackers.*
            ')
            ->where(function ($query) {
                $query->where('documents.created_by', auth()->user()->id)
                    ->orWhere('trackers.receiver_directorate_id', auth()->user()->directorate_id)
                    ->orWhere('doc_copies.emp_id', auth()->user()->employee_id);
            })
            ->where('documents.deleted_at', null)
            ->where('trackers.deleted_at', null)
            ->orderBy('documents.id', 'desc')
            ->groupBy('documentId');

        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }
        if ($filter != '') {
//            return $filter;
            $query = $query->where('documents.title', 'like', '%' . $filter . '%');
        }

        if($request->type != 'undefined'){
            $query->where(function ($query)use ($request) {
                $query->where('trackers.type', $request->type);
            });
        }

        if($request->doc_type_id != 'undefined'){
            $query->where(function ($query)use ($request) {
                $query->where('trackers.doc_type_id', $request->doc_type_id);
            });
        }
        if($request->status_id != 'undefined'){
            $query->where(function ($query)use ($request) {
                $query->where('trackers.status_id', $request->status_id);
            });
        }
//
//        if($request->doc_type_id){
//            $query->where('trackers.doc_type_id', $request->doc_type);
//        }
//
        if($request->in_num){
            $query->where('trackers.in_num', $request->in_num);
        }
        if($request->out_num){
            $query->where('trackers.out_num', $request->out_num);
        }
        if($request->out_date){
            $query->where('trackers.out_date', $request->out_date);
        }
        if($request->phone_number){
            $query->where('trackers.phone_number', $request->phone_number);
        }
        if($request->focal_point_name){
            $query->where('trackers.focal_point_name', $request->focal_point_name);
        }

        if($request->title){
             $query->where('documents.title', 'like', '%' . $request->title . '%');
        }

        if($request->receiver_directorate_id !== 'undefined'){
            $query->where('trackers.receiver_directorate_id', $request->receiver_directorate_id);
        }
        if($request->receiver_employee_id !== 'undefined'){
            $query->where('trackers.receiver_employee_id', $request->receiver_employee_id);
        }
//        if($request->sender_employee_id){
//            $query->where('trackers.sender_employee_id', $request->sender_employee_id);
//        }
//        if($request->sender_directorate_id){
//            $query->where('trackers.sender_directorate_id', $request->sender_directorate_id);
//        }
//
//        if($request->document_type){
//            $query->where('trackers.doc_type_id', $request->document_type);
//        }
        if ($request->from_date) {
            $query->where('trackers.created_at', '>=', dateToMiladi($request->from_date));
        }
        if ($request->to_date) {
            $query->where('trackers.created_at', '<=', dateToMiladi($request->to_date));
        }

        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });


        $query = $query->paginate($per_page);
        return $query;
    }

//    Get general report data
    public function getGeneralReportData($request)
    {
        $query = $this
            ->leftJoin('trackers', 'trackers.document_id', '=', 'documents.id')
            ->leftJoin('doc_copies', 'doc_copies.tracker_id', '=', 'trackers.id')
            ->leftJoin('statuses', 'statuses.id', '=', 'trackers.status_id')
            ->leftJoin('doc_types', 'doc_types.id', '=', 'trackers.doc_type_id')
            ->leftJoin('employees as sender', 'sender.id', '=', 'trackers.sender_employee_id')
            ->leftJoin('employees as receiver', 'receiver.id', '=', 'trackers.receiver_employee_id')
            ->selectRaw("trackers.receiver_directorate_id,sender.name as sender,statuses.name as status,
           receiver.name as receiver,
            doc_types.name as docTypeName,
            trackers.*,documents.*");

        if ($request->in_num) {
            $query->where('trackers.in_num', $request->in_num);

        }
        if ($request->from_date) {
            $query->where('trackers.created_at', '>=', dateToMiladi($request->from_date));
        }
        if ($request->to_date) {
            $query->where('trackers.created_at', '<=', dateToMiladi($request->to_date));
        }
        if ($request->out_num) {
            $query->where('trackers.out_num', $request->out_num);
        }
        if ($request->out_date) {
            $query->where('trackers.out_date', $request->out_date);
        }
        if ($request->phone_number) {
            $query->where('trackers.phone_number', $request->phone_number);
        }
        if ($request->focal_point_name) {
            $query->where('trackers.focal_point_name', $request->focal_point_name);
        }
        if ($request->receiver_directorate_id) {
            $query->where('trackers.receiver_directorate_id', $request->receiver_directorate_id);
        }
        if ($request->receiver_employee_id) {
            $query->where('trackers.receiver_employee_id', $request->receiver_employee_id);
        }
        if ($request->sender_employee_id) {
            $query->where('trackers.sender_employee_id', $request->sender_employee_id);
        }
        if ($request->sender_directorate_id) {
            $query->where('trackers.sender_directorate_id', $request->sender_directorate_id);
        }
        if ($request->doc_type) {
            $query->where('trackers.type', $request->doc_type);
        }
        if ($request->document_type) {
            $query->where('trackers.doc_type_id', $request->document_type);
        }
        if($request->directorate_id) {
            $query->where('trackers.receiver_directorate_id', $request->directorate_id);
        }
        if($request->sadera_wareda) {
            if($request->sadera_wareda == 'sadera'){
                $query->where('trackers.out_num', '!=', null);
            }
            if($request->sadera_wareda == 'wareda'){
                $query->where('trackers.in_num', '!=', null);
            }
        }
        return $query->get();


    }

}
