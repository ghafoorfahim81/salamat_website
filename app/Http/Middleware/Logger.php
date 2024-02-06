<?php

namespace AGEOPS\ANPCS\Http\Middleware;

use AGEOPS\ANPCS\Models\UsmUser;
use Carbon\Carbon;
use Closure;
use MongoDB\Client as Mongo;
use Sinergi\BrowserDetector\Browser;

class Logger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
//    private $startTime;
//    private $endTime;

    public function handle($request, Closure $next)
    {
        $this->startTime = microtime(true);
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $this->endTime = microtime(true);
        $this->log($request, $response);

    }

    protected function log($request, $response)
    {
        $collection = (new Mongo)->{config('custom.LOG_DB_DATABASE')}->{config('custom.LOG_DB_COLLECTION')};
        $url = $request->fullUrl();
        $method = $request->getMethod();
        $ipAddress = $this->getOriginalClientIp($request);
        $request_body = $request->post();
        $request_query_string = $request->query();
        $response_content = json_decode($response->getContent(), true);
        $response_status = $response->getStatusCode();
        $username = auth('api')->user()->getAuthIdentifier();
        $usmUser =UsmUser::where(['username' => $request->username])->first();
        $info = json_decode($usmUser['info'], true);
        $timestamp = Carbon::now()->toDateTimeString();
        $browser = new Browser();
        $browser_details = $browser->getName() . $browser->getVersion();
        if (isset($inner_content['$oid'])) {
            $inner_content['mongoId'] = $response_content['$oid'];
            unset($inner_content['$oid']);
        }

        $inner_content = $this->filterOids($response_content);
        $data = [
            'url' => $url,
            'ip' => $ipAddress,
            'method' => $method,
            'request_body' => $request_body,
            'request_query_string' => $request_query_string,
            'response_content' => $inner_content,
            'response_status' => $response_status,
            'username' => $username,
            'email' => $info['general-information']['email'],
            'role' => $info['contexts'],
            'browser_details' => $browser_details,
            'timestamp' => $timestamp
        ];
        $collection->insertOne($data);
    }

    function filterOids($response)
    {
        $depth = 0;
        $content = json_decode(json_encode($response), true);
        $cb = function (&$content, $recurring_callback) use (&$depth) {
            foreach ($content as &$inner_content) {
                if (isset($inner_content['_id']['$oid'])) {
                    $oid = $inner_content['_id']['$oid'];
                    unset($inner_content['_id']);
                    $inner_content['_id'] = [];
                    $inner_content['_id']['mongoId'] = $oid;
                } else if (is_array($inner_content)) {
                    $recurring_callback($inner_content, $recurring_callback);
                }
            }
        };

        if (isset($content) && is_array($content)) {
            $cb($content, $cb, false);
        }

        return $content;
    }

    function getOriginalClientIp($request): string
    {
        $request = $request ?? request();
        $xForwardedFor = $request->header('x-forwarded-for');
        if (empty($xForwardedFor)) {
            $ip = $request->ip();
        } else {
            $ips = is_array($xForwardedFor) ? $xForwardedFor : explode(', ', $xForwardedFor);
            $ip = $ips[0];
        }
        return $ip;
    }
}
