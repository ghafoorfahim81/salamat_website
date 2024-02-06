<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Province extends Model
{
    use HasFactory, Uuids;

    protected $table = "provinces";

    protected $fillable = [
        'name',
        'zone_id'
    ];

    public function getLocations($request)
    {
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        // return $per_page;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');
        $query = DB::table('provinces')->leftJoin('zones','zones.id','provinces.zone_id')
            ->selectRaw('provinces.*,zones.name as zone');
        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }

        if ($filter != '') {
            $query = $query->where('provinces.name', 'like', '%' . $filter . '%')
                           ->orWhere('zones.name','like', '%' . $filter . '%');
        }

        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });

        return $query->paginate($per_page);
    }
}
