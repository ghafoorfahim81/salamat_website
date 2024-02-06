<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\SoftDeletes;



class DocType extends Model
{
    use softDeletes;
    use HasFactory;

    protected $dates = ['deleted_at'];
    protected $fillable = ['name'];
    public function deadline():HasOne {
        return $this->hasOne(Deadline::class);
      }



      public function getDocumentTypes($request){
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');

        $query = $this;
  
        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }
  
        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });
        $query = $query->paginate($per_page);
        return $query;
    }
}
 