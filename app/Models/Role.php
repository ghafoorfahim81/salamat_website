<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Pagination\Paginator;

class Role extends Model
{
    use HasFactory, Uuids;

    protected $guarded = [];

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
    public function roleList($request)
    {
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');

        $query = $this->selectRaw('roles.*')->where('name','!=','abar tarnegar');
        if ($filter && $filter != '') {

            $query = $query->where(function ($where) use ($filter) {
                $where->where('roles.name', 'like', '%' . $filter . '%')
                    ->orWhere('roles.description', 'like', '%' . $filter . '%');
            });
            // abar tarnegar
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
            ->where('roles.name','!=','abar tarnegar')
            ->first();

        if ($userRole) {
            return false;
        }
        return true;
    }
}
