<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;


class Directorate extends Model
{

    protected $table = 'directorates';
//    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = [
        'id',
        'name_prs',
        'name_en',
        'name_ps',
        'prefix',
        'parent_id',
    ];

    public function trackers()
    {
        return $this->hasMany(Tracker::class, 'receiver_directorate_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    public function departmentHead()
    {
        return $this->hasOne(Employee::class)->whereNotNull('bast')->orderBy('bast');
    }

    public function directorateList($request)
    {
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');
        $name_prs = $request->name_prs;
        $name_ps = $request->name_ps;
        $query = DB::table('directorates')
            ->selectRaw('directorates.*,directorates.name_' . lang() . ' as directorate_name,directorates.id as directorate_id
            ');

        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }
        if ($filter != '') {
            $query->where('directorates.name_' . lang(), 'like', '%' . $filter . '%');

        }

        if ($name_prs != 'null') {
            $query = $query->where('directorates.name_prs', $name_prs);
        }
        if ($name_ps != 'null') {
            $query = $query->where('directorates.name_ps', $name_ps);
        }
        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });
        $query = $query->paginate($per_page);
        return $query;
    }

//    get all directorate for the first time and when search
    public function getDirectorate($keyword = null, $directorate_id = null)
    {
        $query = $this->selectRaw('name_' . lang() . ' as name, id');
        if ($keyword) {
            $query->where('name_' . lang(), 'like', '%' . $keyword . '%');
        }
        if ($directorate_id) {
            return $query->where('directorates.id', $directorate_id)->first();
        }

        return $query->get();
    }

//   get all deputies
    public function getDeputies()
    {
        return $this->selectRaw('name_' . lang() . ' as name,id')
            ->where('parent_id', 1)
            ->get();
    }

//    this function returns the directorates reports

    public function getDirectoratesReports($request)
    {
//        $directorate_id = $request->directorate_id;
//        $query = $this
//            ->leftjoin('trackers', 'trackers.receiver_directorate_id', 'directorates.id')
//            ->leftjoin('doc_types', 'doc_types.id', 'trackers.doc_type_id')
//            ->leftjoin('statuses', 'statuses.id', 'trackers.status_id')
//            ->selectRaw('
//                COALESCE(count(case when statuses.slug = \'pending\' then trackers.id end), 0) as pending,
//                COALESCE(count(case when statuses.slug = \'ongoing\' then trackers.id end), 0) as ongoing,
//                COALESCE(count(case when statuses.slug = \'not-completed\' then trackers.id end), 0) as notCompleted,
//                COALESCE(count(case when statuses.slug = \'completed\' then trackers.id end), 0) as completed,
//                COALESCE(count(case when statuses.slug = \'approved\' then trackers.id end), 0) as approved,
//                COALESCE(count(case when doc_types.slug = \'petition\' then trackers.id end), 0) as petitions,
//                COALESCE(count(case when doc_types.slug = \'letter\' then trackers.id end), 0) as letters,
//                COALESCE(count(case when doc_types.slug = \'suggestion\' then trackers.id end), 0) as suggestions,
//                COALESCE(count(case when statuses.slug = \'rejected\' then trackers.id end), 0) as rejected,
//                COALESCE(count(case when trackers.in_out = \'in\' then trackers.id end), 0) as receives,
//                COALESCE(count(case when trackers.in_out = \'out\' then trackers.id end), 0) as sends,
//                COALESCE(count(trackers.id), 0) as Total,
//                doc_types.name as docType,
//                doc_types.slug as docTypeSlug,
//                directorates.name_' . lang() . ' as directorate
//    ')
//            ->groupBy('statuses.id', 'doc_types.id', 'directorates.id')
//            ->orderBy('directorates.id');
//        if ($directorate_id) {
//            $query->where('trackers.receiver_directorate_id', $directorate_id);
//        }
        $directoratesWithDocTypes = Directorate::crossJoin('doc_types')
            ->leftJoin('trackers', function ($join) {
                $join->on('directorates.id', '=', 'trackers.receiver_directorate_id')
                    ->on('doc_types.id', '=', 'trackers.doc_type_id');
            })
            ->leftJoin('statuses', 'statuses.id', '=', 'trackers.status_id')
            ->leftJoin('doc_copies', 'doc_copies.tracker_id', '=', 'trackers.id')
            ->select(
                'directorates.name_' . lang() . ' as directorate',
                'directorates.id as directorate_id',
                'doc_types.name as document_type',
                'doc_types.slug as docTypeSlug',
                DB::raw('COUNT(trackers.id) as total_trackers'),
                DB::raw('SUM(CASE WHEN statuses.slug = "completed" THEN 1 ELSE 0 END) as completed'),
                DB::raw('SUM(CASE WHEN statuses.slug = "approved" THEN 1 ELSE 0 END) as approved'),
                DB::raw('SUM(CASE WHEN statuses.slug = "pending" THEN 1 ELSE 0 END) as pending'),
                DB::raw('SUM(CASE WHEN statuses.slug = "ongoing" THEN 1 ELSE 0 END) as ongoing'),
                DB::raw('SUM(CASE WHEN statuses.slug = "rejected" THEN 1 ELSE 0 END) as rejected'),
                DB::raw('SUM(CASE WHEN statuses.slug = "not_completed" THEN 1 ELSE 0 END) as not_completed'),
                DB::raw('SUM(CASE WHEN doc_types.slug = "suggestion" THEN 1 ELSE 0 END) as suggestions'),
                DB::raw('SUM(CASE WHEN doc_types.slug = "letter" THEN 1 ELSE 0 END) as letters'),
                DB::raw('SUM(CASE WHEN doc_types.id = "requisition" THEN 1 ELSE 0 END) as requisitions'),
                DB::raw('SUM(CASE WHEN trackers.in_num IS NOT NULL THEN 1 ELSE 0 END) as receives'),
                DB::raw('SUM(CASE WHEN trackers.out_num IS NOT NULL THEN 1 ELSE 0 END) as sends'),
            )
            ->whereNull('trackers.deleted_at')
            ->groupBy('directorates.name_' . lang(), 'doc_types.slug')
            ->orderByDesc(
                DB::raw('(
            SELECT COUNT(*)
            FROM trackers
            WHERE trackers.receiver_directorate_id = directorates.id
        )')
            )
            ->get();
        if ($request->directorate_id) {
            $directoratesWithDocTypes = $directoratesWithDocTypes->where('directorate_id', $request->directorate_id);
        }


//        $ccQuery = Directorate::query()
//            ->join('employees', 'directorates.id', '=', 'employees.directorate_id')
//            ->join('doc_copies', 'employees.id', '=', 'doc_copies.employee_id')
//            ->join('trackers', 'doc_copies.tracker_id', '=', 'trackers.id')
//            // ... joins for statuses, doc_types, and necessary aggregations ...
//            ->select(
//                'directorates.id as directorate_id',
//            // ... other selects and aggregations ...
//            );
//
//        $finalQuery = $directoratesWithDocTypes->union($ccQuery)
//            ->select(
//                'directorate_id',
//                DB::raw('SUM(total_trackers) as total_trackers'),
//            )
//            ->groupBy('directorate_id')
//            ->get();

        return $directoratesWithDocTypes;


        return $directoratesWithDocTypes;

    }

//    this function returns the directorate ranking trackers
    public function getRankingReportData($status)
    {
//        return $status;
        $query = DB::table('directorates')
            ->leftJoin('trackers', 'directorates.id', '=', 'trackers.receiver_directorate_id')
            ->leftJoin('statuses', 'trackers.status_id', '=', 'statuses.id')
            ->selectRaw('
                directorates.id,
                directorates.name_' . lang() . ' as directorate,
                COALESCE(SUM(CASE WHEN statuses.slug = "pending" THEN 1 ELSE 0 END), 0) as pending,
                COALESCE(SUM(CASE WHEN statuses.slug = "accepted" THEN 1 ELSE 0 END), 0) as accepted,
                COALESCE(SUM(CASE WHEN statuses.slug = "ongoing" THEN 1 ELSE 0 END), 0) as ongoing,
                COALESCE(SUM(CASE WHEN statuses.slug = "rejected" THEN 1 ELSE 0 END), 0) as rejected,
                COALESCE(SUM(CASE WHEN statuses.slug = "completed" THEN 1 ELSE 0 END), 0) as completed,
                        COALESCE(SUM(CASE WHEN statuses.slug = "notCompleted" THEN 1 ELSE 0 END), 0) as notCompleted
            ')
            ->groupBy('directorates.id', 'directorates.name_' . lang())
            ->orderByDesc($status)
            ->get();

        return $query;
    }

    public function topFive()
    {
        $query = (new Directorate())::select(
            'directorates.id',
            'directorates.name_prs',
            DB::raw('COUNT(*) as document_count')
        )
            ->join('trackers', 'directorates.id', '=', 'trackers.receiver_directorate_id')
            ->whereNull('trackers.deleted_at')
            ->groupBy('directorates.id', 'directorates.name_prs')
            ->orderByDesc('document_count')
            ->take(5);
        return $query->get();
    }


}
