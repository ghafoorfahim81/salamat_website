<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class Deadline extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['days', 'doc_type_id','security_level_id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function tracks():HasMany {
        return $this->hasMany(Tracker::class);
      }

    public function docType():BelongsTo {
    return $this->belongsTo(DocType::class);
    }
}
