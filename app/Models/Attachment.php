<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'file',
        'table_id',
        'table_name',
        'assign_name',
        'original_name',
    ];
    public function tracker():BelongsTo {
        return $this->BelongsTo(Tracker::class);
      }
}
