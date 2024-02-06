<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Pagination\Paginator;

use App\Models\Psycho\Psychologist;
use App\Traits\Uuids;

class User extends Authenticatable
{
    use HasFactory,
        HasProfilePhoto,
        Notifiable,
        TwoFactorAuthenticatable,
        HasApiTokens,
        Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'profile_photo_path',
        'current_team_id',
        'setting',
        'companies',
        'current_company',
        'type',
        'location_id',
        'province_id'
    ];
    protected $table = 'users';
    protected $primayKey='id';
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
    ];


    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'user_roles', 'user_id', 'role_id');
    }

    public function psychologist()
    {
        return $this->hasOne(Psychologist::class);
    }


    /**
     * userList function
     *  get user list base on condition
     *
     * @param integer $start_page
     * @param integer $per_page
     * @param string $filter
     * @return void
     */
    public function userList($request)
    {
        $filter = $request->input('search_keyword');
        $per_page = $request->input('per_page') ? $request->input('per_page') : 10;
        $start_page = $request->input('current_page');
        $order_by = $request->input('order_by');
        $order_direction = $request->input('order_direction');

        $query = $this->leftjoin('user_roles', 'user_roles.user_id', 'users.id')
            ->leftjoin('roles', 'roles.id', 'user_roles.role_id')
            ->selectRaw("users.*,
        GROUP_CONCAT(roles.name) AS role_name")
            ->groupBy('users.id');


        if ($filter && $filter != '') {
            $query = $query->where(function ($where) use ($filter) {
                $where->where('users.name', 'like', '%' . $filter . '%')
                    ->orWhere('users.email', 'like', '%' . $filter . '%')
                    ->orWhere('roles.name', 'like', '%' . $filter . '%');
            });
        }

        if ($order_direction != '' || $order_by != '') {
            $query = $query->orderBy($order_by, $order_direction);
        }


        Paginator::currentPageResolver(function () use ($start_page) {
            return $start_page;
        });

        return $query->paginate($per_page);
    }

    /**
     * userDetail function
     * get user detail by id
     * @param int $id
     * @return void
     */
    public function userDetail($id = 0)
    {
        if ($id) {

            return $this->leftjoin('user_roles', 'user_roles.user_id', 'users.id')
                ->leftjoin('roles', 'roles.id', 'user_roles.role_id')
                ->selectRaw('users.*,
            GROUP_CONCAT(roles.id) AS role_id,
            GROUP_CONCAT(roles.name) AS role')
                ->where('users.id', $id)
                ->first();
        }
    }


    /**
     * userDetail function
     * get user detail by id
     * @param int $id
     * @return void
     */
    public function userRoles($id)
    {
        return $this->leftjoin('user_roles', 'user_roles.user_id', 'users.id')
            ->leftjoin('roles', 'roles.id', 'user_roles.role_id')
            ->selectRaw("roles.id AS id,roles.name as name")
            ->where('users.id', $id)->get();
    }


    // get user permissions
    public function userPermissions($userid)
    {
        return $this->join('user_roles', 'user_roles.user_id', 'users.id')
            ->join('roles', 'roles.id', 'user_roles.role_id')
            ->leftjoin('role_permissions', 'role_permissions.role_id', 'roles.id')
            ->leftjoin('permissions', 'permissions.id', 'role_permissions.permission_id')
            ->selectRaw("permissions.name")
            ->where('users.id', $userid)->get();
    }

    // get user permissions based on permission
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
}
