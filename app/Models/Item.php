<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable=[
        'category_id',
        'item_type_id',
        'unit_of_measure_id',
        'quantity_threshold',
        'name_en',
        'name_ps',
        'name_prs',
        'description',
    ];
    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function item_type() {
        return $this->belongsTo(ItemType::class);
    }



    public function items($request){
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');
        $category_id   = $request->category_id;
        $item_type_id  = $request->item_type_id;
        $unit_measure_id  = $request->unit_measure_id;

        $query = DB::table('items')
        ->leftJoin('unit_of_measures', 'unit_of_measures.id', '=', 'items.unit_of_measure_id')
        ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
        ->leftJoin('item_types', 'item_types.id', '=', 'items.item_type_id')
        ->selectRaw('unit_of_measures.name_'.lang().' as measure,unit_of_measures.id as measure_id, items.name_'.lang().' as name,
                categories.name_'.lang().' as category, categories.slug as category_slug,
                item_types.name_'.lang().' as item_type, item_types.slug as type_slug,
                items.id, items.name_'.lang().' as item_name, items.description');

        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }
        if ($filter != '') {
            $query->where('items.name_'.lang(),'like', '%' . $filter . '%')
            ->orWhere('item_types.name_'.lang(),'like', '%' . $filter . '%')
            ->orWhere('categories.name_'.lang(),'like', '%' . $filter . '%')
            ->orWhere('unit_of_measures.name_'.lang(),'like', '%' . $filter . '%');
        }
        if ($category_id != 'null') {
            $query = $query->where('items.category_id',$category_id);
        }

        if ($item_type_id != 'null') {
            $query = $query->where('items.item_type_id', $item_type_id);
        }
        if ($unit_measure_id != 'null') {
            $query = $query->where('items.unit_of_measure_id', $unit_measure_id);
        }

        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });
        $query = $query->paginate($per_page);
        return $query;
    }

    public function getItems($keyword=null,$item_id=null,$category_id=null,$item_type_id=null,$unit_measure_id=null,$form_name=null,$form_id=null,$slug=null,$type=null)
    {
        $query = DB::table('items')
            ->leftJoin('unit_of_measures', 'unit_of_measures.id', '=', 'items.unit_of_measure_id')
            ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
            ->leftJoin('item_types', 'item_types.id', '=', 'items.item_type_id')
            ->selectRaw('unit_of_measures.name_'.lang().' as measure, unit_of_measures.id as measure_id, items.name_'.lang().' as name,
                    categories.name_'.lang().' as category, categories.slug as category_slug,
                    item_types.name_'.lang().' as item_type, item_types.slug as type_slug,
                    items.id, items.id as item_id, items.name_'.lang().' as item_name, items.description,
                    COALESCE(inQ.tq, 0) + COALESCE(returnQ.tq, 0) - COALESCE(dQ.tq, 0) - COALESCE(auctionQ.tq, 0) as total_on_hand_quantity,
                    COALESCE(dQ.tq, 0) - COALESCE(returnQ.tq, 0) as total_distributed_quantity,
                    COALESCE(auctionQ.tq, 0) as total_auction_quantity')
            ->leftJoin(DB::raw('(select sum(`quantity`) as tq, item_id from stocks where in_out = "in" and form_name = "meem7" group by item_id) as inQ'), 'items.id', '=', 'inQ.item_id')
            ->leftJoin(DB::raw('(select sum(`quantity`) as tq, item_id from stocks where in_out = "in" and form_name = "fecen8" group by item_id) as returnQ'), 'items.id', '=', 'returnQ.item_id')
            ->leftJoin(DB::raw('(select sum(`quantity`) as tq, item_id from stocks where in_out = "out" and form_name = "fecen5" group by item_id) as dQ'), 'items.id', '=', 'dQ.item_id')
            ->leftJoin(DB::raw('(select sum(`quantity`) as tq, item_id from stocks where in_out = "out" and form_name = "fecen1" group by item_id) as auctionQ'), 'items.id', '=', 'auctionQ.item_id');

            if($keyword)
            {
                if($type){
                    $query->where('items.name_'.lang(),'like', '%' . $keyword . '%')
                          ->where('categories.slug',$type);
                    if($type ==='vehicle-parts') {
                        $query->orwhere('categories.slug', 'wage');
                    }
                    }
                else{
                    $query->where('items.name_'.lang(),'like', '%' . $keyword . '%')
                    ->orWhere('item_types.name_'.lang(),'like', '%' . $keyword . '%')
                    ->orWhere('categories.name_'.lang(),'like', '%' . $keyword . '%')
                    ->orWhere('unit_of_measures.name_'.lang(),'like', '%' . $keyword . '%');
                }
            }
            if($item_id)
            {
                return $query->where('items.id',$item_id)->first();
            }
            if($category_id)
            {
                $query->where('items.category_id',$category_id);
            }
            if($item_type_id)
            {
                $query->where('items.item_type_id',$item_type_id);
            }
            if($slug)
            {
                $query->where('categories.slug',$slug);
            }
            if($unit_measure_id)
            {
                $query->where('items.unit_of_measure_id',$unit_measure_id);
            }
            if ($keyword) {
                return $query->orderBy('id', 'desc')->get();
            }
        return $query->orderBy('id', 'desc')->limit(10)->get();
    }

//    this function is used for report and excel
    public function itemReport($request)
    {
        // DB::connection()->enableQueryLog();
        if($request->report_type =='vehicle_expenses') {
            $query = DB::table('sejel_fecen5s')
        ->leftjoin('fecen5s', 'sejel_fecen5s.fecen5_id', 'fecen5s.id')
        ->leftjoin('fecen5_details', 'fecen5_detail_id', 'fecen5_details.id')
        ->leftjoin('items', 'fecen5_details.item_id', 'items.id')
        ->leftjoin('driver_expenditures', 'fecen5_details.id', 'driver_expenditures.fecen5_detail_id')
        ->leftjoin('sejels', 'sejels.id', 'sejel_fecen5s.sejel_id')
        ->leftjoin('items as vehicle', 'vehicle.id', 'sejels.vehicle_id')
        ->leftjoin('unit_of_measures as measure', 'measure.id', 'fecen5_details.measure_id')
        ->leftjoin('employees as drivers', 'drivers.id', 'sejels.driver_id')
        ->selectRaw('fecen5_details.item_quantity as distributed_quantity,
                   driver_expenditures.quantity as expenditure_quantity,
                    fecen5_details.item_quantity-ifNull(sum(driver_expenditures.quantity),0) as remind_quantity,
                    fecen5_details.unit_price as price, vehicle.name_'.lang().' as vehicle,sejels.sejel_number,
                    sejels.chassis,
                    fecen5s.fiscal_year, items.name_'.lang().' as item_name, measure.name_'.lang().' as measure,
                    drivers.name as driver, drivers.father_name as driver_father_name,
                    fecen5s.fecen9_type, fecen5s.fecen5_number,
                    fecen5s.issue_date as fecen5_date, fecen5_details.id as fecen5_detail_id
        ')->whereIn('fecen5s.fecen9_type', array('oil', 'repairing', 'moblin'))
        ->groupBy('fecen5_details.id');
            if($request->item_id !='undefined')
                    {
                        $query  = $query->where('vehicle.id',$request->item_id);
                    }
            if($request->chassis !='null')
            {
                $query  = $query->where('sejels.chassis','like', '%'.$request->chassis.'%');
            }
            if($request->sejel_number !='null')
            {
                $query  = $query->where('sejels.sejel_number','like', '%'.$request->sejel_number.'%');
            }
            if($request->employee_id !='undefined')
                {
                    $query  = $query->where('fecen5_details.employee_id',$request->employee_id);
                }
            if($request->fiscal_year !='null')
                {
                    $query  = $query->where('fecen5s.fiscal_year',$request->fiscal_year);
                }
            if($request->from_date !='null')
                {
                    $date = dateToMiladi($request->from_date);
                    $query  = $query->whereDate('fecen5s.date','>=',$date);
                }
            if($request->to_date !='null')
                {
                    $date = dateToMiladi($request->to_date);
                    $query  = $query->whereDate('fecen5s.date','<=',$date);
                }
            if($request->fc9_type !='undefined')
            {
                $query  = $query->where('fecen5s.fecen9_type',$request->fc9_type);
            }
            return $query->get();
        } else {
            // return 99;
        $query = DB::table('stocks')
            ->selectRaw('items.name_'.lang().' as name, COALESCE(stockMeasure.name_'.lang().', unit_of_measures.name_'.lang().') as measure,
                categories.name_'.lang().' as category, item_statuses.name_'.lang().' as status,
                item_types.name_'.lang().' as type, directorates.name_'.lang().' as directorate,
                item_specs.specifications as spec,sum(stocks.unit_price) as unit_price, sum(stocks.quantity) as quantity,
                stocks.form_name, motameds.name as motamed, stocks.fiscal_year, stocks.obtained_from as company,
                donors.name_'.lang().' as donor, stocks.purchase_type, itemDetail.tag_number, itemDetail.serial_number,
                itemDetail.chassis, itemDetail.engine, itemDetail.number_palate, itemDetail. model,
                employees.name as employee, CONCAT(employees.name,"-",employees.father_name) as employee_full_name, stocks.date, stocks.form_number,
                COALESCE(SUM(CASE WHEN stocks.in_out = "in" AND stocks.form_name = "meem7" THEN stocks.quantity ELSE 0 END) +
                         SUM(CASE WHEN stocks.in_out = "in" AND stocks.form_name = "fecen8" THEN stocks.quantity ELSE 0 END), 0) -
                COALESCE(SUM(CASE WHEN stocks.in_out = "out" AND stocks.form_name = "fecen5" THEN stocks.quantity ELSE 0 END) +
                         SUM(CASE WHEN stocks.in_out = "out" AND stocks.form_name = "fecen1" THEN stocks.quantity ELSE 0 END), 0) AS available,
                   abs(COALESCE(SUM(CASE WHEN stocks.in_out = "out" AND stocks.form_name = "fecen5" THEN stocks.quantity ELSE 0 END) -
                         SUM(CASE WHEN stocks.in_out = "in" AND stocks.form_name = "fecen8" THEN stocks.quantity ELSE 0 END), 0)) AS distributed,
                COALESCE(SUM(CASE WHEN stocks.in_out = "in" AND stocks.form_name = "meem7" THEN stocks.quantity ELSE 0 END) +
                         SUM(CASE WHEN stocks.in_out = "in" AND stocks.form_name = "fecen8" THEN stocks.quantity ELSE 0 END) -
                         SUM(CASE WHEN stocks.in_out = "out" AND stocks.form_name = "fecen5" THEN stocks.quantity ELSE 0 END) -
                         SUM(CASE WHEN stocks.in_out = "out" AND stocks.form_name = "fecen1" THEN stocks.quantity ELSE 0 END), 0) AS total')
            ->leftJoin('items', 'stocks.item_id', '=', 'items.id')
            ->leftJoin('item_details as itemDetail', 'stocks.item_detail_id', '=', 'itemDetail.id')
            ->leftJoin('unit_of_measures', 'unit_of_measures.id', '=', 'unit_of_measure_id')
            ->leftJoin('unit_of_measures as stockMeasure', 'stockMeasure.id', '=', 'stocks.measure_id')
            ->leftJoin('categories', 'categories.id', '=', 'category_id')
            ->leftJoin('item_statuses', 'item_statuses.id', '=', 'status_id')
            ->leftJoin('item_types', 'item_types.id', '=', 'item_type_id')
            ->leftJoin('item_specs', 'item_specs.id', '=', 'stocks.spec_id')
            ->leftJoin('directorates', 'directorates.id', '=', 'stocks.directorate_id')
            ->leftJoin('motameds', 'motameds.id', '=', 'stocks.motamed_id')
            ->leftJoin('employees', 'employees.id', '=', 'stocks.employee_id')
            ->leftJoin('donors', 'donors.id', '=', 'donor_id');

            if($request->report_type =='general_report')
            {
                $query =  $query->groupBy('stocks.item_id', 'stocks.measure_id');
            }
            if($request->report_type =='distributed_report')
            {
                $query->leftJoin('meem7s', 'meem7s.id', '=', 'stocks.parent_id')
                ->selectRaw('meem7s.meem7_number')->groupBy('stocks.id')
                ->where('stocks.form_name','fecen5');
            }
            if($request->report_type =='reminded_items')
            {
                $query->leftjoin(DB::raw("(select sum(`quantity`) as tq,item_id, item_detail_id, spec_id,id,
            unit_price, parent_id, measure_id from stocks where in_out = 'out'
             and parent_form_name='meem7'
            group by item_id, spec_id,measure_id,unit_price) as dQ"),
            function($join)
            {
                $join->on('stocks.item_id', '=', 'dQ.item_id');
                $join->on('stocks.spec_id', '=', 'dQ.spec_id');
                $join->on('stocks.unit_price', '=', 'dQ.unit_price');
                $join->on('stocks.measure_id', '=', 'dQ.measure_id');
                $join->on('stocks.form_id', '=', 'dQ.parent_id');
            })->selectRaw('(ifnull((stocks.quantity),0)-ifnull(dQ.tq,0)) as on_hand_quantity')->groupBy('stocks.id');
            }
            if ($request->report_type=='depreciation_report')
            {
                $query =  $query->groupBy('stocks.id');
            }
            if($request->item_id !='undefined')
            {
                $query  = $query->where('stocks.item_id', $request->item_id);
            }
            if($request->spec_id !='undefined')
            {
                $query  = $query->where('stocks.spec_id',$request->spec_id)->groupBy('stocks.spec_id');
            }
            if($request->meem7_number !='null')
            {
                $query  = $query->where('stocks.form_number','like', '%'.$request->meem7_number);
            }
            if($request->category_id !='undefined')
            {
                $query  = $query->where('items.category_id',$request->category_id);
            }
            if($request->item_status_id !='undefined')
            {
                $query  = $query->where('stocks.status_id',$request->item_status_id);
            }
            if($request->item_type_id !='undefined')
            {
                $query  = $query->where('item_types.id',$request->item_type_id);
            }
            if($request->company !='null')
            {
                $query  = $query->where('stocks.obtained_from','like', '%' . $request->company . '%');
            }
            if($request->motamed_id !='undefined')
            {
                $query  = $query->where('stocks.motamed_id',$request->motamed_id);
            }
            if($request->purchase_type !='undefined')
            {
                $query  = $query->where('stocks.purchase_type',$request->purchase_type);
            }
            if($request->directorate_id !='undefined')
            {
                $query  = $query->where('stocks.directorate_id',$request->directorate_id);
            }
            if($request->from_date !='null')
            {
                $date = dateToMiladi($request->from_date);
                $query  = $query->whereDate('stocks.date','>=',$date);
            }
            if($request->to_date !='null')
            {
                $date = dateToMiladi($request->to_date);
                $query  = $query->whereDate('stocks.date','<=',$date);
            }
            if($request->tag_number !='null')
            {
                $query  = $query->where('itemDetail.tag_number',$request->tag_number);
            }
            if($request->serial_number !='null')
            {
                $query  = $query->where('itemDetail.serial_number',$request->serial_number)
                                ->orWhere('itemDetail.chassis',$request->serial_number)
                                ->orWhere('itemDetail.engine',$request->serial_number);
            }
            if($request->hangar_id !='undefined')
            {
                $query  = $query->where('stocks.hangar_id',$request->hangar_id);
            }
            if($request->employee_id !='undefined')
            {
                $query  = $query->where('stocks.employee_id',$request->employee_id);
            }
            if($request->fiscal_year !='null')
            {
                $query  = $query->where('stocks.fiscal_year',$request->fiscal_year);
            }
            $query = $query->get();
            // $queries = \DB::getQueryLog();
            //             \Log::info($queries);
        return $query;
        }
    }
    public function getItemsInFiscalYear()
    {
         $latest_fiscal_years =  Stock::orderByDesc('fiscal_year')->limit(3)->distinct()->pluck('fiscal_year');
        //  where('item_types.slug','=', 'consuming')
         $consuming_items = Stock::where('form_name','fecen5')
         ->leftJoin('items', 'item_id', 'items.id')
         ->selectRaw('stocks.fiscal_year,items.name_'.lang().' as item_name,items.id as item_id, sum(quantity) as total_quantity')
         ->groupBy('item_id','fiscal_year')->where('items.id',1494);
        //  $temArray = [];
        //  foreach($consuming_items as $item) {
        //     $temp = {$item->fiscal_year: [$item]};
        //     array_push($temArray, );
        //  }
        //  dd($temArray);
        //  \Log::info($consuming_items);
        //  dd($consuming_items);
         return $consuming_items->get();
    }
    public function lastDistrebutedItems() {
        $query = DB::table('items')
            ->join('stocks as dStock',function($join){
                $join->on('dStock.item_id','=','items.id')
                    ->where('dStock.form_name','=','fecen5');
            })
            ->join('unit_of_measures as stockMeasure', 'stockMeasure.id', 'dStock.measure_id')
            ->selectRaw('items.name_'.lang().' as item_name,
            stockMeasure.name_'.lang().' as measure,
            dStock.date as fc5_date,
            dStock.quantity as distributed_quantity')
            ->orderBy('dStock.date', 'desc')->limit(10);
        return $query->get()->map(function($item) {
            $item->fc5_date = miladiToHijriOrJalali($item->fc5_date);
            return $item;
        });

        return $query->get();
    }
}
