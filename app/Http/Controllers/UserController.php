<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Notification;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $user;

    /**
     * __construct function initialize class
     *
     * @param User $user
     */
    public function __construct(User $user, UserRole $userRole)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return (new User)->getUsers($request);
        }
        return view('user_management.users.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $p = Permission::whereNotIn('permissions.name', ['user_create', 'user_view', 'user_edit', 'user_list', 'user_delete', 'role_delete', 'role_create', 'role_view', 'role_edit', 'role_list'])->get();
        $roles = getRecordFromTable('roles');
        $positions = getRecordFromTable('positions');
        $employees = (new Employee())->getEmployee();
        $permission_data = \App\Http\Controllers\RoleController::permissions();
        return view('user_management.users.create', [
            'roles' => json_encode($roles),
            'permission_data' => json_encode($permission_data),
            'positions' => json_encode($positions),
            'employees' => json_encode($employees)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string|max:255|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }
        // return $request;
        $role_id = $request->get('role_id');

        $employee = (new Employee())->find($request->employee_id);
        DB::beginTransaction();
        $storeUser = $this->user->create([
            'email' => $request->get('email'),
            'user_name' => $request->get('user_name'),
            'password' => bcrypt($request->get('password')),
            'employee_id' => $request->employee_id,
            'directorate_id' => $employee->directorate_id,
            'created_by' => auth()->user()->id,
        ]);

//        dd($storeUser);
        if ($storeUser) {
            foreach ($role_id as $key => $value) {
                (new UserRole())->create([
                    'role_id' => $value,
                    'user_id' => $storeUser->id
                ]);
            }
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => __('general_words.record_saved')
            ]);

        }
//            DB::commit();
//            updateCreatedByOrUpdatedBy('users','created_by');
//            return response()->json([
//                'status' => 200,
//                'message' => __('general_words.record_saved')
//            ]);
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return response()->json([
//                'status' => 400,
//                'message' =>  __('general_words.something_went_wrong')
//            ]);
//        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user = $user->load(['directorate', 'employee','roles']);
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:191',
            'password' => 'required|max:191',


        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $user = Auth()->user();
            // return $user;
            $password = $request->get('password');
            if ($password) {
                $password = bcrypt($password);
            }
            $storeUser = $user->update([
                'email' => $request->get('email'),
                'password' => $password,
                'updated_by' => auth()->user()->id,
            ]);
            return ['status' => 200, 'message' => __('general_words.record_updated')];
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string|max:255|unique:users,user_name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        }
        try {
            $user = $this->user->findOrFail($id);
            $role_ids = (array)$request->get('role_id');
            $password = $request->get('password') ? bcrypt($request->get('password')) : null;

            $employee = (new Employee())->find($request->employee_id);
            DB::beginTransaction();

            $user->update([
                'user_name' => $request->get('user_name'),
                'email' => $request->get('email'),
                'password' => $password,
                'employee_id' => $request->employee_id,
                'directorate_id' => $request->directorate_id,
                'updated_by' => auth()->user()->id,
            ]);


            (new UserRole())->where('user_id', $id)->delete();

            foreach ($role_ids as $value) {
                (new UserRole())->create([
                    'role_id' => $value,
                    'user_id' => $id
                ]);
            }

            DB::commit();
            return ['status' => 200, 'message' => __('general_words.record_updated')];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 422);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $user = $this->user->where('id', $id)->first();
            (new UserRole())->where('user_id', $id)->delete();
            $user->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => __('general_words.record_updated')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'message' => __('general_words.something_went_wrong')
            ]);
        }
    }
    public function deactivate($id)
    {
        try {
            DB::beginTransaction();
            $user = $this->user->where('id', $id)->first();
            $user->update([
                'status' => 0,
            ]);

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => __('general_words.record_updated')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'message' => __('general_words.something_went_wrong')
            ]);
        }
    }

    public function checkUsername(Request $request)
    {
        $username = $request->username;

        // Check if the username exists in the database
        $isAvailable = !User::where('user_name', $username)->exists();

        return response()->json(['isAvailable' => $isAvailable]);
    }

    public function readNotification($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->markAsRead();
            return redirect($notification->data['url']);
        }
        abort(404, 'Notification not found');
    }
}
