<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Currency extends Model
{
    use HasFactory, Uuids;
    protected $table = "currencies";
    protected $fillable = [
        'exchange_rate',
        'name',
        'code',
        'symbol',
        'flag',
        'format',
        'exchange_rate',
        'other_name',
        'created_at',
        'company_id'
    ];



    public function getall()
    {
        $this->get();
    }
    public function getCurrencies($request)
    {
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');
        $query = DB::table('currencies')->selectRaw('*');
        // ->groupBy('id');
        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }

        if ($filter != '') {
            $query = $query->where('currencies.name', 'like', '%' . $filter . '%')
                ->orwhere('currencies.code', 'like', '%' . $filter . '%')
                ->orwhere('currencies.symbol', 'like', '%' . $filter . '%')
                ->orwhere('currencies.format', 'like', '%' . $filter . '%')
                ->orwhere('currencies.exchange_rate', 'like', '%' . $filter . '%');
        }

        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });

        return $query->paginate($per_page);
    }
    /**
     * Display a listing of the resource.
     *chackdata used at currecycontroller destroy function
     */
    public function checkData($id)
    {
        $transactions = DB::table('currencies')->join('transactions', 'transactions.unit', 'currencies.code')
            ->where('currencies.id', $id)
            ->where('currencies.company_id', auth()->user()->current_company)
            ->first();
        if ($transactions) {
            return true;
        }
        return false;
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
        ->where('currencies.company_id', auth()->user()->current_company);
        if ($code != null)
            $query = $query->where('currencies.code', $code);
        return $query->get();
    }
    public function allcurrencyList($code = null)
    {
        $query = DB::table('currency_lists')->selectRaw("
            id,
            name,
            code,
            symbol,
            flag,
            format,
            exchange_rate,
            exchange_rate AS rate")
        ->where('currencies.company_id', auth()->user()->current_company);
        if ($code != null)
            $query = $query->where('code', $code);
        return $query->get();
    }
    public function defaultCurrency()
    {
        return DB::table('currencies')->join('home_currencies', 'home_currencies.currency_id', 'currencies.id')
            ->selectRaw('currencies.code as code,currencies.exchange_rate as rate,currencies.symbol,currencies.flag')
            ->where('currencies.company_id', auth()->user()->current_company)->first();
    }
    //    get currencies for opening ledger

    public function getOpeningCurrency()
    {
        return DB::table('currencies')->selectRaw('code,exchange_rate as rate,0 as amount,null as type')->where('company_id', auth()->user()->current_company)->get();
        return DB::table('currencies')->selectRaw('code,exchange_rate as rate,0 as amount,null as type')->where('company_id', auth()->user()->current_company)->get();
    }
}
