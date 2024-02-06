<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Language;
use Sinergi\BrowserDetector\Device;
use Sinergi\BrowserDetector\Os;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $browser = new Browser();
        $language = new Language();
        $browser_details = $browser->getName() . $browser->getVersion();
        $device = new Device();
        $os = new Os();

        $user   = auth()->user()->id;
        \DB::table('logs')->insert([
            'table'      =>'fecen9s',
            'date'       =>Carbon::now(),
            'log_type'   =>'store',
            'type'       =>'fc9',
            'url'        =>$os->getName(),
            'ip_address' =>request()->ip(),
            'user_id'    =>$user,
            'data'       =>json_encode($request->query()),
        ]);
        return $next($request);
    }
}
