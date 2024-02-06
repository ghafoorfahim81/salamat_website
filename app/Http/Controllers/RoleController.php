<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Role;
use App\Models\PermissionGroup;
use App\Models\UserPermission;
use App\Models\RolePermission;
use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    protected $role;

    /**
     * __construct function initialize the class object
     *
     * @param Role $rule
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * index function get record based on condition
     * role list
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $data['directorates'] = getRecordFromTable('directorates');
        if ($request->ajax()) {
            return $this->role->roles($request);
        }
        return view('user_management.roles.index',$data);
    }

    /**
     * create function create new roel
     *
     * @return void
     */
    public function create()
    {
        $permission_data = $this->permissions();
        return view('user_management.roles.create', [
            'permission_data' => json_encode($permission_data),
        ]);
    }

    /**
     * store function
     *  store new resource
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|max:255',
            'permission_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=> 400,
                'message' => __('general_words.missing_inputs'),
                'errors'=> $validator->messages()
            ]);
        }
        else{
        $permission_id = explode(',', $request->get('permission_id'));
         try {
             DB::beginTransaction();
            $data = [
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'slug' => 'other',
            ];
            $role = Role::create($data);
            foreach ($permission_id as $key => $value) {
                (new RolePermission())->create([
                    'role_id' => $role->id,
                    'permission_id' => $value
                ]);
            }
             DB::commit();
             return response()->json([
                 'status' => 200,
                 'message' => __('general_words.record_saved')
             ]);
         } catch (\Exception $e) {
             return response()->json([
                 'status' => 400,
                 'message' =>  __('general_words.something_went_wrong')
             ]);
         }
         }


    }

    /**
     * view function get specific record
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function edit(Request $request, $id = 0)
    {
        if ($id) {
            $role = $this->role->find($id);
            $permission_data = $this->permissions($id);
            $permission_data = json_encode($permission_data);
            return view('user_management.roles.edit', [
                'role' => $role,
                'permission_data' => $permission_data,
            ]);
        }

    }

    // show function display inserted record
    public function show($id)
    {
        $this->setMenu(['view#role' => 'role/' . $id]);

        if ($id) {
            $role = $this->role->find($id);
            $permission_data = $this->permissions($id);


            $permission_data = json_encode($permission_data);

            return view('user_management.role.show', compact('permission_data', 'role'));
        }

    }

    /**
     * update function update specific record
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id . '|regex:/^\S*$/u',
            'permission_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=> 400,
                'message' => __('general_words.missing_inputs'),
                'errors'=> $validator->messages()
            ]);
        }
        else{

            // if ($id) {
                $permission_id = explode(',', $request->get('permission_id'));
                try {
                    DB::beginTransaction();
                    $role = $this->role->find($id);
                    $role->update([
                        'name' =>$request->name,
                        'description' => $request->get('description'),
                    ]);


                    (new RolePermission())->where('role_id', $id)->delete();

                    foreach ($permission_id as $key => $value) {
                        (new RolePermission())->create([
                            'role_id' => $role->id,
                            'permission_id' => $value
                        ]);
                    }
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => __('general_words.record_updated')
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 400,
                        'message' =>  __('general_words.something_went_wrong')
                    ]);
                // }
            }
        }
    }

    /**
     * destroy function delete one or more by thier ids
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $role = $this->role->where('id', $id)->first();
                $check = (new Role())->canDelete($role->id);
                if ($check) {
                    (new RolePermission())->whereIn('role_id', [$role->id])->delete();
                    $role->delete();
                } else {
                    DB::rollBack();
                    return response()->json([
                        'status' => 400,
                        'message' =>  __('general_words.something_went_wrong')
                    ]);
                }

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => __('general_words.record_deleted')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'message' =>  __('general_words.something_went_wrong')
            ]);
        }
    }

    public static function permissions($role_id = null, $user_id = null)
    {
        $role = null;
        $rolePermission = null;
        if ($role_id > 0) {
            $role = (new Role())->find($role_id);
            $rolePermission = (new RolePermission())->where('role_id', $role->id)->get();
        }
        if ($user_id) {
            $rolePermission = (new UserPermission())->where('user_id', $user_id)->get();
        }

        $permission_data = [];
        $Permissions = PermissionGroup::with('permissions')->orderBy('created_at','asc')->get();
        foreach ($Permissions as $key => $value) {
            $temp = [];
            $nameParts = explode('_', $value->name);
            $suffix = end($nameParts);

            foreach ($value->permissions as $key1 => $value1) {
                $check = null;
                if ($rolePermission) {
                    $flag = $rolePermission->where('permission_id', $value1->id)->first();
                    if ($flag) {
                        $check = 1;
                    }
                }
                $nameParts = explode('_', $value1->name);
                $suffix = end($nameParts);


                array_push($temp, [
                    'checked' => $check,
                    'permission_id' => $value1->id,
                    'permission_name' => __('permission.' . $suffix),
                ]);
            }
            array_push($permission_data, [
                'permission_group_id' => $value->id,
                'permission_group_name' => __('permission.' . $value->name),
                'permissions' => $temp,
                'checked' => null
            ]);
        }
        //$permission_data=json_encode($permission_data);
        return $permission_data;
    }

}
