<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class DocCopy extends Model
{
    use softDeletes;
    use HasFactory;

    protected $dates = ['deleted_at'];
    protected $fillable = ['tracker_id', 'emp_id'];

    public function track():BelongsTo {
        return $this->BelongsTo(Tracker::class);
      }
}
