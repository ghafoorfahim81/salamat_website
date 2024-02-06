<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Log extends Model
{
    use HasFactory;
    protected $fillable= [
        'date',
        'table',
        'log_type',
        'form_name',
        'form_id',
        'user_id',
        'url',
        'old_data',
        'data',
        'user_data',
    ];
    public function logs($request){
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');
        $user_id = $request->input('user_id');
        $date = $request->input('date');
        $directorate_id = $request->input('directorate_id');
        $query = DB::table('logs')
        ->leftJoin('users', 'user_id', 'users.id')
        ->leftjoin('directorates', 'users.directorate_id', 'directorates.id')
          ->selectRaw('logs.*,directorates.name_'.lang().' as directorate_name,users.name as user');
        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }
        if ($filter != '') {
            $query = $query->where('users.name', 'like', '%' . $filter . '%')
                            ->orWhere('logs.date', 'like', '%' . $filter . '%')
                            ->orWhere('logs.log_type', 'like', '%' . $filter . '%');
        }
//        if ($directorate_id != 'undefined') {
//            $query = $query->where('users.directorate_id', $directorate_id);
//        }
        if ($date != 'null') {
            $date = dateToMiladi($date);
            $query = $query->where('logs.date', $date);
        }
        if ($user_id != 'undefined') {
            $query = $query->where('logs.user_id', $user_id);
        }
        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });
        return $query->paginate($per_page);
    }

}
