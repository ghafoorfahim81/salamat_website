<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PermissionGroup extends Model
{
    use HasFactory;

    protected  $dates = ['deleted_at'];
    protected $guarded = [];
    public function permissions()
    {
       return $this->belongsToMany('App\Models\Permission',
       'permission_permission_groups','permission_group_id','permission_id');
    }
}
