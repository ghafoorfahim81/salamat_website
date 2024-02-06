<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
class Employee extends Model
{

    protected $table = 'employees';

    protected $fillable=[
        'id',
        'name',
        'last_name',
        'father_name',
        'position',
        'gender',
        'phone',
        'bast',
        'email',
        'department',
        'directorate_id',
        'hire_status',
        'deleted_at'
    ];

    // protected function name(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn () => $this->name .'-' . $this->father_name
    //     );
    // }



    public function directorate()
    {
        return $this->belongsTo(Directorate::class);
    }
    public function employeeList($request){
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');
        $name   = $request->name;
        $father_name  = $request->father_name;
        $directorate_id  = $request->directorate_id;

        $query = DB::table('employees')
        ->leftJoin('directorates', 'directorates.id', '=', 'employees.directorate_id')
        ->selectRaw('employees.*,directorates.name_'.lang().' as directorate_name,directorates.id as directorate_id
            ');

        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }
        if ($filter != '') {
            $query->where('employees.name','like', '%' . $filter . '%')
            ->orWhere('employees.last_name','like', '%' . $filter . '%')
            ->orWhere('directorates.name_'.lang(),'like', '%' . $filter . '%')
            ->orWhereRaw('CONCAT(name, "-", father_name) LIKE ?', ['%' . $filter . '%']);
        }
        if ($directorate_id != 'null') {
            $query = $query->where('employees.directorate_id',$directorate_id);
        }
        if ($name != 'null') {
            $query = $query->where('employees.name',$name);
        }
        if ($father_name != 'null') {
            $query = $query->where('employees.father_name',$father_name);
        }
        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });
        $query = $query->paginate($per_page);
        return $query;
    }
    public function getEmployee($keyword=null,$id=null, $directorate_id=null)
    {
        $query   = $this->selectRaw('employees.id,CONCAT(name,"-",father_name) AS full_name,father_name,position,name, last_name,
        directorates.name_'.lang().' as directorate_name')
                        ->leftJoin('directorates', 'directorates.id','employees.directorate_id');
        if($keyword){
            $query->where('employees.name','like', '%' . $keyword . '%')
                  ->orWhereRaw('CONCAT(name, "-", father_name) LIKE ?', ['%' . $keyword . '%']);
        }
        if($id)
        {
            return $query->where('employees.id',$id)->first();
        }
        if($directorate_id) {
            $query->where('employees.directorate_id',$directorate_id);
        }
        if ($keyword) {
            return $query->get();
        }
        return $query->limit(10)->get();
    }

    public function employeeDetails($employee_id)
    {
        return $this->leftjoin('directorates','directorates.id','employees.directorate_id')
                    ->selectRaw('
                    directorates.name_'.lang().' as dir_name,
                    employees.*
                    ')
            ->where('employees.id',$employee_id)
            ->first();
    }

    public function getDirectorateUsers($directorate_id){
        return $this->join('users','users.employee_id','employees.id')
                    ->where('users.directorate_id',$directorate_id)
                    ->get(['employees.name', 'employees.id','employees.directorate_id','employees.father_name', 'employees.position']);
    }


}
