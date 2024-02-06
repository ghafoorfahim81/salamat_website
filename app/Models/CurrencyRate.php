<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class CurrencyRate extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['exchange_rate', 'date', 'user_id', 'currency_id', 'company_id'];
    public function getRates($request)
    {

        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');

        $query = DB::table('currency_rates')->leftjoin('currencies', 'currencies.id', '=', 'currency_rates.currency_id')
            // ->leftjoin('users', 'users.id', '=', 'currency_rates.user_id')
            ->selectRaw('currency_rates.*, currencies.code as code, currencies.name as name, currencies.format, currencies.symbol');
        if ($filter && $filter != '') {

            $query = $query->where(function ($where) use ($filter) {
                $where->where('currencies.name', 'like', '%' . $filter . '%')
                ->orWhere('currencies.code', 'like', '%' . $filter . '%');
            });
        }

        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }


        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });

        return $query->paginate($per_page);
        // $query = DB::table('currency_rates')->leftjoin('currencies', 'currencies.id', '=', 'currency_rates.currency_id')
        //     // ->leftjoin('users', 'users.id', '=', 'currency_rates.user_id')
        //     ->selectRaw('currency_rates.*, currencies.code as code, currencies.name as name, currencies.format, currencies.symbol');
        // // ->groupBy('currency_rates.id');
        // if ($descending === "true") {
        //     $query = $query->orderBy($sort_by, 'desc');
        // } else {
        //     $query = $query->orderBy($sort_by, 'asc');
        // }
        // if ($filter != '') {
        //     $query = $query->where('name', 'like', '%' . $filter . '%');
        // }
        // Paginator::currentPageResolver(function () use ($current_page) {
        //     return $current_page;
        // });
        // return $query->paginate($per_page);
    }
    /**
     * Display a listing of the resource.
     *get report of currency details used in exportcontroller
     */
    public function exportCurrencyDetails($from_date = '', $to_date = '')
    {
        $query = DB::table('currency_rates')->leftjoin('users', 'users.id', '=', 'currency_rates.user_id')
            ->leftjoin('currencies', 'currencies.id', '=', 'currency_rates.currency_id')
            ->selectRaw("users.name as Name,
            currencies.code as Code,
            currency_rates.exchange_rate as Exchange,
            currency_rates.date as Date")
            ->where('currency_rates.company_id', auth()->user()->current_company)
            ->orderBy('currency_rates.date', 'DESC');
        if ($from_date && $from_date != '')
            $query = $query->whereDate('currency_rates.date', '>=', $from_date);

        if ($to_date && $to_date != '')
            $query = $query->whereDate('currency_rates.date', '<=', $to_date);
        return $query->distinct()->get();
    }
    //    get currencies for opening ledger

    public function getOpeningCurrency()
    {
        return DB::table('currencies')->selectRaw('code,exchange_rate as rate,0 as amount,null as type')->where('company_id', auth()->user()->current_company)->get();
    }
    /**
     * Display a listing of the resource.
     *
     *currencies list
     */
    public function currencyList($code = null)
    {
        $query = DB::table('currencies')->selectRaw("
            currencies.id,
            currencies.name,
            currencies.code,
            currencies.symbol,
            currencies.flag,
            currencies.exchange_rate,
            currencies.exchange_rate AS rate")
        ->where('company_id', auth()->user()->current_company);
        if ($code != null)
            $query = $query->where('currencies.code', $code);
        return $query->get();
    }

    public function getRate($id)
    {
       return  DB::table('currency_rates')
        ->leftJoin('currencies','currencies.id','currency_rates.currency_id')
        ->where('currency_id', $id)
        ->where('currencies.company_id', auth()->user()->current_company)
        ->orderByDesc('currency_rates.created_at')->first('currency_rates.exchange_rate');
    }
}
