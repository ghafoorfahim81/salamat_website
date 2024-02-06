<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;

class ExternalDirectorate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['name','id'];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => miladiToHijriOrJalali($value),
            set: fn ($value) => strpos($value, '-') ? $value : dateToMiladi($value),
        );
    }

    public function getExternalDirectorates($request){
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');

        $query = $this->selectRaw('external_directorates.*');
        if ($filter != '') {
            $query = $query->where('external_directorates.name', 'like', '%' . $filter . '%');
        }
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
