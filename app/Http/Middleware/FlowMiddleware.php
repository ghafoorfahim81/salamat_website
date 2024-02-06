<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlowMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$table)
    {

        $column = null;
        if($table=='card_to_card_flows')
        {
            $column = 'card_to_card_id';
        }
        else{
            $explodeColumn = explode('_', $table);
            $column  = $explodeColumn[0].'_id';
        }
        $checkFlow = DB::table($table)->where($column,$request->route('id'))->orderBy($table.'.created_at','desc')->first();
        if($checkFlow){
            if($checkFlow->status_slug =='edit' || $checkFlow->status_slug =='new')
            {
             return $next($request);
            }
            else{
                return redirect('forbidden');

            }
        }
    }
}
