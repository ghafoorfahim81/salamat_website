<?php
use App\library\Dateconverter;
use App\Models\Tracker;use App\Models\User;
use Carbon\Carbon;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;
use Illuminate\Http\Request;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Language;
use Sinergi\BrowserDetector\Device;
use Sinergi\BrowserDetector\Os;


    function currentDate() {
        return miladiToHijriOrJalali(Carbon::now()->format('Y-m-d'));
    }
    function dateToMiladi($inputeDate){
        if(!$inputeDate) {
            return $inputeDate;
        }
            $defaultDate = 'jalali';
            if ($defaultDate === 'gregorian') {
                return $inputeDate;
            }
            if (!Str::contains($inputeDate, '/')) {
                return $inputeDate;
            }
            $inputeDate = explode('/', $inputeDate);
            $y = $inputeDate[0];
            $m = $inputeDate[1];
            $d = $inputeDate[2];
            if ($defaultDate === 'jalali') {
                return (new Jalalian($y, $m, $d))->toCarbon()->toDateString() ;
            }
            else if ($defaultDate === 'hijri') {
                return hijriToMiladiDate($y, $m, $d);
            } else {
                return 'date type is not specified';
            }
    }

    function miladiToHijriOrJalali($inputeDate){
        if (!$inputeDate) {
            return $inputeDate;
        }
            $defaultDate = 'jalali';
            if ($defaultDate === 'gregorian') {
                return $inputeDate;
            }
            if ($defaultDate === 'jalali') {
                return stripslashes(Jalalian::fromCarbon(Carbon::parse($inputeDate))->format('Y/m/d'));
            }
    }

    function hijriToMiladiDate($y, $m, $d) {
            $date =  (int)((11 * $y + 3) / 30) + 354 * $y +
            30 * $m - (int)(($m - 1) / 2) + $d + 1948440 - 385;
            $miladiDate = explode('/', jdtogregorian($date));
            $miladiDate = $miladiDate[2].'-'.$miladiDate[0].'-'.$miladiDate[1];
                return $miladiDate;
        }


    function perPage($returnPerPageArray=false)
    {

        if($returnPerPageArray)
        {
            $appPerPage= [5,10,20,50,100];
            return json_encode($appPerPage);
        }
        return 10;
    }
    function lang(){
        return app()->getLocale();
    }
//    This is function get name and id from every master table
    function getRecordFromTable($table, $id=null, $ids=[])
    {
        $query = \DB::table($table)->select($table.'.name_'.lang().' '.'as name',$table.'.id');
        if ($id !== null) {
            return $query->where('id', $id)->first();
        }
        if (count($ids)>0) {
            return $query->whereIn('id', $ids)->get();
        }
        return $query->get();
    }
    // if user has passed permissions
    function hasPermission($permission=array(),$booleanResult=true)
    {
        if(!is_array($permission))
        {
            $permission=[$permission];
        }
        $user=auth()->user();
        if($user)
        {
            return (new User())->userPermissionsCheck($user->id,$permission,$booleanResult);
        }
    }


    function checkSlug($slug)
    {
        $user   = Auth()->user()->id;
        $roles  = DB::table('user_roles')->leftJoin('roles','roles.id','user_roles.role_id')
            ->where('user_roles.user_id',$user)
            ->get(['roles.slug'])->toArray();
        if (array_search($slug, array_column($roles, 'slug')) !== FALSE) {
            return true;
        }
        else {
            return false;
        }
    }
    /**
     * check the flow of a table
     *
     */


    /**
     * Update or insert the follow for specific table.
     *
     */

    function insertFlow($table,$column,$id)
    {
        $user   = auth()->user()->id;
        DB::table($table)->insert([
            $column           => $id,
            'status_slug'     => 'new',
            'date'            => Carbon::now(),
            'updated_by'      => $user,
            'created_by'      => $user,
        ]);
    }

    function getFlow($table,$id){
        return DB::table($table)->selectRaw('ReturnLastFormFlow('.$table.','.$id.') as flow')->first();
    }

//    function insertLog($table,$log_type,$url,$form_name,$form_id,$data=null,$old_data=null,$request)
//    {
//        $browser = new Browser();
//        $language = new Language();
//        $browser_details = $browser->getName() . $browser->getVersion();
//        $device = new Device();
//        $os = new Os();
//
//        $userData = [
//            'browser'           => $browser_details,
//            'operating_system'  => $os->getName(),
//            'ip_address'        => getOriginalClientIp($request),
//            'device_name'       => $device->getName(),
//        ];
//        $user   = auth()->user()->id;
//        DB::table('logs')->insert([
//            'table'      => $table,
//            'date'       => Carbon::now(),
//            'log_type'   => $log_type,
//            'form_name'  => $form_name,
//            'form_id'    => $form_id,
//            'url'        => $url,
//            'user_id'    => $user,
//            'user_data'  => json_encode($userData),
//            'old_data'  => $old_data?json_encode($old_data):null,
//            'data'       => $data?json_encode($data):null,
//        ]);
//    }
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









?>
