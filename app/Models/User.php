<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;






class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
//    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_name',
        'email',
        'password',
        'status',
        'position_id',
        'employee_id',
        'first_login_at',
        'directorate_id'
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'employee_id',
        'directorate_id',
        'first_login_at'
    ];



    public function getEmployeeIdAttribute()
    {
        return $this->attributes['employee_id'];
    }
//    public function routeNotificationForDatabase()
//    {
//        return $this->id; // Adjust this based on your model's primary key or identifier
//    }

    public function roles()
    {
        return $this->hasMany(UserRole::class,
             'user_id');
    }
    public function getDirectorateIdAttribute()
    {
        return $this->attributes['directorate_id'];

    }

    public function getFirstLoginAtAttribute()
    {
        // Your implementation here
    }
    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');

    // }


    public function directorate(): BelongsTo
    {
        $localeColumn = "name_" . app()->getLocale();
        return $this->belongsTo(Directorate::class, 'directorate_id')->select(['id', $localeColumn . ' as name']);
    }


    public function employee():BelongsTo {
        return $this->belongsTo(Employee::class, 'employee_id');
    }



    public function getUsers($request){

       $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');
        $query = DB::table('users')
            ->leftJoin('directorates','directorates.id','users.directorate_id')
            ->leftjoin('employees as employee', 'employee.id','users.employee_id')
            ->selectRaw('users.*,directorates.name_ps as directorate_name,
            directorates.name_'.lang().' as directorate,
            employee.name as employee_name,
                IF(users.status = 1, "' . __('general_words.active') . '", "' . __('general_words.deactivate') . '") as status
            ')->whereNull('users.deleted_at');

        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }
         if ($filter != '') {
            $query = $query
                ->where('users.user_name', 'like', '%' . $filter . '%')
                ->orwhere('users.email', 'like', '%' . $filter . '%');
         }
        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });
        $query = $query->paginate($per_page);
        return $query;
    }
    public function userDetail($id = 0)
    {
        if ($id) {
            return $this->leftjoin('user_roles', 'user_roles.user_id', 'users.id')
                ->leftjoin('roles', 'roles.id', 'user_roles.role_id')
                ->selectRaw('users.*,
            GROUP_CONCAT(roles.id) AS role_id,
            GROUP_CONCAT(roles.name_'.lang().') AS role')
                ->where('users.id', $id)
                ->first();
        }
    }

    public function users($request){
        $filter           = $request->input('search_keyword');
        $per_page         = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page       = $request->input('current_page');
        $order_by         = $request->input('order_by');
        $order_direction  = $request->input('order_direction');
        $name             = $request->user_name;
        $email            = $request->email;
        $query = DB::table('users')
            ->selectRaw('users.*,
        IF(users.status = 1, "' . __('general_words.active') . '", "' . __('general_words.deactivate') . '") as status
            ');
        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }
        if ($filter != '') {
            $query = $query
                ->where('users.user_name', 'like', '%' . $filter . '%')
                ->orwhere('users.email', 'like', '%' . $filter . '%');
        }
        if ($name != 'null') {
            $query = $query->where('users.user_name', 'like', '%' . $name . '%');
        }
        if ($email != 'null') {
            $query = $query->where('users.email', 'like', '%' . $email . '%');
        }
        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });

        return $query->paginate($per_page);
    }
    public function userPermissionsCheck($userid, $permissions = array(), $booleanResult = true)
    {
        $flag = true;
        $has_all = false;
        $intersected_permission = array();

        if (is_array($permissions)) {
            if (count($permissions)) {
                $user = auth()->user();

                $checkPermissionCount = $this->getUserPermission($user->id, $permissions);

                if (count($checkPermissionCount)) {

                    foreach ($checkPermissionCount as $uperm) {
                        array_push($intersected_permission, $uperm->name);
                    }
                    if (count($checkPermissionCount) == count($permissions)) {
                        $flag = true;
                        $has_all = true;
                    } else {
                        $flag = true;
                        $has_all = false;
                    }
                } else {
                    $flag = false;
                    $has_all = false;
                }
                // check if

            }
        }

        if ($booleanResult) {
            return $flag;
        }

        return [
            'flag' => $flag,
            'has_all' => $has_all,
            'permissions' => $intersected_permission
        ];
    }
    // get user permission

    public function getUserPermission($userId, $permissions = array())
    {
        $query = $this->join('user_roles', 'user_roles.user_id', 'users.id')
            ->join('roles', 'roles.id', 'user_roles.role_id')
            ->leftjoin('role_permissions', 'role_permissions.role_id', 'roles.id')
            ->leftjoin('permissions', 'permissions.id', 'role_permissions.permission_id')
            ->selectRaw("permissions.name")
            ->where('users.id', $userId);
        if (count($permissions)) {
            $query = $query->whereIn('permissions.name', $permissions);
        }

        return $query->get();
    }
    // public function roles():HasMany {
    //     return $this->hasMany(UserRole::class);


    // }



}
