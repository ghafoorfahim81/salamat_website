<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PermissionPermissionGroup extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];
    protected $guarded = [];
}
