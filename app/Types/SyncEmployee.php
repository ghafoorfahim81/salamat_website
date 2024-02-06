<?php

namespace App\Types;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Employee;

class SyncEmployee
{
     // this function is for migrating employees from local auth database
     public static function operate() {
        $insertData = [];
        $avialableEmployees = [];
        $isRecordModified = false;
        $headers = ['Accept' => 'application/json'];
        $employees = Http::get(env('CUSTOM_API_LOCAL_HR_BASE_URL') . 'api/inventory-system/get-employees', $headers)->throw();
        $employees = $employees->json();
        $employeeModel = new Employee();

        // Get the IDs of all existing employees
        $existingIds = $employeeModel->pluck('id')->toArray();

        // Split the employees into chunks of 3000 records for faster insertions
        $chunkedEmployees = array_chunk($employees, 3000);

        // Loop through each chunk of employees
        foreach ($chunkedEmployees as $chunk) {
                $insertData = [];

                // Loop through each employee in the chunk
                foreach ($chunk as $employee) {
                    // Check if the employee already exists in the database
                    if (in_array($employee['id'], $existingIds)) {
                        // Update the employee record
                        $employeeModel->where('id', $employee['id'])->update($employee);
                        $isRecordModified = true;
                    } else {
                        // Add the employee record to the insert data
                        $insertData[] = $employee;
                    }
                }

                // Insert any new employee records
                if (!empty($insertData)) {
                    $employeeModel->insert($insertData);
                    $isRecordModified = true;
                }
            }

            // Return a response based on whether any records were modified or inserted
            if ($isRecordModified) {
                return response()->json('Employees were modified or inserted');
            } else {
                return response()->json('Employees were not modified or inserted');
            }
        // $insertData = [];
        // $avialableEmployees = [];
        // $isRecordModefied = false;
        // $headers = ['Accept' => 'application/json'];
        // $employees = Http::get(env('CUSTOM_API_LOCAL_HR_BASE_URL') . 'api/inventory-system/get-employees', $headers);
        // $employees = json_decode($employees, true);
        // $employeeModel = (new Employee());
        // $existingRecords = DB::table('employees')->get();


        // foreach($employees as $key => $employee) {
        //     foreach($avialableEmployees as $avialableEmp) {
        //             if ($avialableEmp->id == $employee['id']) {
        //                 if ($avialableEmp->name != $employee['name']
        //                 || $avialableEmp->last_name != $employee['last_name']
        //                 || $avialableEmp->father_name != $employee['father_name']
        //                 || $avialableEmp->position != $employee['position']
        //                 || $avialableEmp->gender != $employee['gender']
        //                 || $avialableEmp->phone != $employee['phone']
        //                 || $avialableEmp->email != $employee['email']
        //                 || $avialableEmp->directorate_id != $employee['directorate_id'])
        //                  {
        //                     $isRecordModefied = $employeeModel::where('id','=', $employee['id'])
        //                     ->update([
        //                         'name' => $employee['name'],
        //                         'last_name' => $employee['last_name'],
        //                         'father_name' => $employee['father_name'],
        //                         'position' => $employee['position'],
        //                         'gender' => $employee['gender'],
        //                         'phone' => $employee['phone'],
        //                         'email' => $employee['email'],
        //                         'directorate_id' => $employee['directorate_id'],
        //                         'hire_status' => $employee['hire_status'],
        //                     ]);
        //                 }
        //                 unset($employees[$key]);
        //                 break;
        //             }
        //     }
        // }

        // if ($employees) {
        //     foreach(array_chunk($employees,3000) as $emp) {
        //         $isRecordModefied = $employeeModel::insert($emp);
        //     }
        // }
        // unset($employees);
        // if ($isRecordModefied === false) {
        //     return response()->json('Employees are not modefied or inserted');
        // }
        // return response()->json('Employees are modefied or inserted');
    }
}