<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;


class FiscalYears extends Model
{
    use HasFactory;
    use softDeletes;



    protected $dates = ['deleted_at'];
    protected $fillable = ['name',
        'start_date',
        'end_date'
    ];

    public function getFiscalYears($request){
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');
        $query = $this;

        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }

        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });
        $query = $query->paginate($per_page);
        return $query;
    }

    public function getFiscalYear($date) {
        $fiscalYear = $this->where('start_date', '<=', $date)->where('end_date', '>=' ,$date)->first();
        return $fiscalYear;
    }

//
//    public function generateIncomingDocNum($directorateId,$date) {
////dd($directorateId, $date);
//        $year = $this->where('start_date', '<=', $date)->where('end_date', '>=' ,$date)->first();
////        return $year;
//        $latestInNum = (new Tracker)
//            ->where('receiver_directorate_id', $directorateId)
//            ->where('in_date', '>=', $year->start_date)
//            ->where('in_date', '<=', $year->end_date)
//            ->max('in_num');
//        return (int) $latestInNum + 1;
//    }

//    public function generateOutgoingDocNum($directorateId,$date) {
//
//        $year = $this->where('start_date', '<=', $date)->where('end_date', '>=' ,$date)->first();
//        $latestInNum = (new Tracker)
//            ->where('receiver_directorate_id', $directorateId)
//            ->where('in_date', '>=', $year->start_date)
//            ->where('in_date', '<=', $year->end_date)
//            ->max('out_num');
//        return (int) $latestInNum + 1;
//    }


}
