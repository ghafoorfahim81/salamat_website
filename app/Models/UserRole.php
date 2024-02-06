<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserRole extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];
    protected $table = 'user_roles';
    protected $fillable=['id','user_id','role_id'];
    protected $guarded = ['created_at','updated_at','deleted_at'];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
