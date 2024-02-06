<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\Directorate;
use Illuminate\Support\Facades\Validator;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $employee;
    public function __construct(Employee $employee)
    {
        $this->employee   = $employee;
    }
    public function index(Request $request)
    {
        $data['employee'] = $this->employee->getEmployee();
        $data['directorates'] = (new Directorate())->getDirectorate();
        if ($request->ajax()) {
            return $this->employee->employeeList($request);
        }
        return view('settings.employee.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'father_name' => 'required',
            'directorate_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => __('general_words.missing_inputs'),
                'errors' => $validator->messages()
            ]);
        }
            else {
                try {
                    DB::beginTransaction();
                    $employees = $this->employee->create([
                        'name' => $request->name,
                        'last_name' => $request->last_name,
                        'father_name' => $request->father_name,
                        'phone' => $request->phone,
                        'email' => $request->email,
                        'position' => $request->position,
                        'department' => $request->department,
                        'gender' => $request->gender,
                        'directorate_id' => $request->directorate_id,
                        'created_by' => auth()->user()->id
                    ]);
                    DB::commit();
                    return response()->json([
                        'id' => $employees->id,
                        'status' => 200,
                        'message' => __('general_words.record_saved'),
                    ]);
                } catch (\Exception $e) {
                    DB::rollBack();
                    \Log::error($e);
                    return response()->json([
                        'status' => 400,
                        'message' => __('general_words.something_went_wrong'),
                        'errors' => $e
                    ]);
                }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->employee->find($id);
        $data->selected_dir = getRecordFromTable('directorates', $data->directorate_id);
        return $data;
    }
    public function update(Request $request, $id)
    {
        // return $id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'father_name' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => __('general_words.missing_inputs'),
                'errors' => $validator->messages()
            ]);
        } else {
            try {
                $details = Employee::find($id);
                DB::beginTransaction();
                $update = $details->update([
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'father_name' => $request->father_name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'position' => $request->position,
                    'department' => $request->department,
                    'gender' => $request->gender,
                    'directorate_id' => $request->directorate_id,
                    'updated_by' => auth()->user()->id
                ]);
                // insertLog('fecen9_details', __('general_words.update_item'),   '/fc9/' . $request->fecen9_id, __('fc9.fc9'), $details->fecen9_id, $update,$details, $request);
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'employee' => $this->employee->getEmployee(null, $id),
                    'message' => __('general_words.record_updated'),
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error($e);
                return response()->json([
                    'status' => 400,
                    'message' => __('general_words.something_went_wrong'),
                    'errors' => $e
                ]);
            }
       }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
