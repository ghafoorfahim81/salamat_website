<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class DeadlineType extends Model
{
    use softDeletes;
    use HasFactory;

    protected $dates = ['deleted_at'];
    protected $fillable = ['name'];
    public function tracks():HasMany {
        return $this->hasMany(Tracker::class);
      }
}
