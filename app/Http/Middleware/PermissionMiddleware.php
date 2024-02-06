<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


use App\Traits\HasPermissionTrait;
use Auth;
class PermissionMiddleware
{
    use HasPermissionTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,...$permission)
    {

        if(Auth::check())
        {
            $toCheckPermission=array();
            if(is_array($permission))
            {
                foreach($permission AS $p)
                {

                    if($p !='')
                    {
                        $tempPermission=explode('|',$p);
                        foreach($tempPermission AS $tempP)
                        {
                            $tempP=trim($tempP);
                            if($tempP !='')
                            {
                                if(!in_array($tempP,$toCheckPermission))
                                array_push($toCheckPermission,$tempP);
                            }
                        }
                    }

                }
            }
            $userPermission=$this->hasPermission($toCheckPermission);
            if($userPermission)
            {
                if(is_array($userPermission))
                {
                    if($userPermission['flag'])
                    {
                        return $next($request);
                    }
                    else
                    {
                        if ($request->ajax()) {
                            return response(__('message.401_msg'),401);
                        } else {
                            return redirect('forbidden');

                        }
                        //return $next($request);
                    }
                }
            }
            else
            {
                if ($request->ajax()) {
                    return response(__('message.401_msg'),401);
                } else {
                    return redirect('forbidden');
                }
                //return $next($request);
            }
        }
        else
        {
            return redirect('login');
        }
    }
}
