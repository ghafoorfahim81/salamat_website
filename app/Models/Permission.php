<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Pagination\Paginator;
class Permission extends Model
{
    use HasFactory, Uuids;

    protected $guarded = [];
    
    public function groups()
    {
        return $this->belongsToMany('App\Models\PermissionGroup',
    'permission_permission_groups','permission_id','permission_group_id');
    }
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role',
        'role_permissions','permission_id','role_id');
    }
}
