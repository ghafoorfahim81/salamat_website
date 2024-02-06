<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Pagination\Paginator;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = [];
    protected $table="roles";
    protected $fillable = [
        'name','slug','description'
    ];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => miladiToHijriOrJalali($value),
            set: fn ($value) => strpos($value, '-') ? $value : dateToMiladi($value),
        );
    }
    public function users()
    {
        return $this->belongsToMany('App\Models\User',
            'user_roles', 'role_id', 'user_id');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission',
            'role_permissions', 'role_id', 'permission_id');
    }

    /**
     * ruleList function
     * get role list based on condition
     *
     * @param integer $start_page
     * @param integer $per_page
     * @param string $filter
     * @return void
     */

    public function roles($request)
    {
        // return $request;
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');
        $name   = $request->name;
        // $email         = $request->email;
        $directorate_id       = $request->directorate_id;
        // $query = $this->select('roles.*','roles.name_'.lang().' as name');
        $query = $this->selectRaw('roles.*');
        if ($filter != '') {
            $query = $query->where('roles.name', 'like', '%' . $filter . '%');
        }
        // if ($name != 'null') {
        //     $query = $query->where('roles.name', 'like', '%' . $name . '%');
        //             ->orWhere('roles.name', 'like', '%' . $name . '%')
        //             ->orWhere('roles.name_ps', 'like', '%' . $name . '%');

        // }
        // if ($email != 'null') {
        //         $query = $query->where('roles.email', 'like', '%' . $email . '%');
        //     }
        if ($directorate_id != 'null') {
            $query = $query->where('roles.directorate_id', $directorate_id);
        }
        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }


        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });

        return $query->paginate($per_page);
    }

    // check if can delete record
    public function canDelete($id = null)
    {
        $userRole = $this->join('user_roles', 'user_roles.role_id', 'roles.id')
            ->where('roles.id', $id)
            ->first();

        if ($userRole) {
            return false;
        }
        return true;
    }


    public function getRoles($keyword=null,$role_id=null)
    {
        $query   = $this->selectRaw('name_'.lang().' as name, id');
        if($keyword){
            $query->where('name_'.lang(),'like', '%' . $keyword . '%');
        }
        if($role_id)
        {
            return $query->where('roles.id',$role_id)->first();
        }
        return $query->limit(10)->get();
    }
}
