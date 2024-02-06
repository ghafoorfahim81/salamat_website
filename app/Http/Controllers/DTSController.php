<?php

namespace App\Http\Controllers;

use App\Models\Deadline;
use App\Models\DeadlineType;
use App\Models\Directorate;
use App\Models\DocType;
use App\Models\Document;
use App\Models\Employee;
use App\Models\ExternalDirectorate;
use App\Models\FollowupType;
use App\Models\InDoc;
use App\Models\Role;
use App\Models\SecurityLevel;
use App\Models\Status;
use App\Models\Tracker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DTSController extends Controller
{

    public function getDropdownItems(Request $request)
    {
        $type = explode(',', $request->type);
        $response = [];
        if ($type) {
            if (in_array('employees', $type)) {
                $response['employees'] = (new Employee())->getEmployee(null, null);;
            }
            if (in_array('followupTypes', $type)) {
                $response['followupTypes'] = FollowupType::all();
            }
            if (in_array('securityLevels', $type)) {
                $response['securityLevels'] = SecurityLevel::all();
            }
            if (in_array('deadlineTypes', $type)) {
                $response['deadlineTypes'] = DeadlineType::all();
            }
            if (in_array('statuses', $type)) {
                $response['statuses'] = Status::all();
            }
            if (in_array('deadlines', $type)) {
                $response['deadlines'] = Deadline::all();
            }
            if (in_array('documentTypes', $type)) {
                $response['documentTypes'] = DocType::all();
            }
            if (in_array('external_dirs', $type)) {
                $response['externalDirectorates'] = ExternalDirectorate::get(['name', 'id'])->take(100);
            }
            if (in_array('deputies', $type)) {
                $response['deputies'] = (new Directorate())->getDeputies();
            }
            if (in_array('directorates', $type) || in_array('internal_dirs', $type) || in_array('filter_dirs', $type)) {
                $response['directorates'] = (new Directorate())->getDirectorate();
            }
            if (in_array('roles', $type)) {
                $response['roles'] = (new Role())->get(['name', 'id']);
            }
            return $response;
        }
    }

    public function checkEmail(Request $request)
    {
        $result = DB::table('users')->where('email', $request->email)->first();
        if ($result) {
            return 1;
        } else {
            return 0;
        }
    }

    // this function is for migrating directorates from local auth database
    public function getDirectoratesFromLocalHR()
    {
        $insertData = [];
        $avialableDirectorates = [];
        $isRecordModefied = false;
        $headers = ['Accept' => 'application/json'];
        $directorates = Http::get(env('CUSTOM_API_LOCAL_HR_BASE_URL') . 'api/dms/get-directorates', $headers);
        $directorates = json_decode($directorates, true);
        $directorateModel = (new Directorate());
        $avialableDirectorates = $directorateModel::all();
        foreach ($directorates as $directorate) {
            $directoratename = $directorate['name_en'];
            $prefix = $this->extractPrefix($directoratename);
            array_push($insertData, [
                'id' => $directorate['id'],
                'name_en' => $directorate['name_en'],
                'name_prs' => $directorate['name'],
                'name_ps' => $directorate['name_pa'],
                'parent_id' => $directorate['parent'],
                'prefix' => $prefix,
            ]);
        }

        foreach ($insertData as $key => $insertDir) {
            foreach ($avialableDirectorates as $avialableDir) {
                $directoratename = $insertDir['name_en'];
                $prefix = $this->extractPrefix($directoratename);
                if ($avialableDir->id == $insertDir['id']) {
                    if ($avialableDir->name_en !== $insertDir['name_en']
                        || $avialableDir->name_prs !== $insertDir['name_prs']
                        || $avialableDir->name_ps !== $insertDir['name_ps']
                        || $avialableDir->parent_id !== $insertDir['parent_id']) {
                        $isRecordModefied = $directorateModel::where('id', '=', $insertDir['id'])->update([
                            'name_en' => $insertDir['name_en'],
                            'name_prs' => $insertDir['name_prs'],
                            'name_ps' => $insertDir['name_ps'],
                            'parent_id' => $insertDir['parent_id'],
                            'prefix' => $prefix,
                        ]);
                    }
                    unset($insertData[$key]);
                    break;
                }
            }
        }

        if ($insertData) {
            $isRecordModefied = $directorateModel::insert($insertData);
        }
        unset($insertData);
        if ($isRecordModefied === false) {
            return response()->json('Directorates are not modefied or inserted');
        }
        return response()->json('Directorates are modefied or inserted');
    }

    public function extractPrefix($directoratename)
    {
        // Logic to extract prefix from the directorate name
        // You may need to customize this logic based on your specific requirements
        $prefix = ''; // Default value

        // Example logic: Extract first letters of each word
        $words = explode(' ', $directoratename);
        foreach ($words as $word) {
            $prefix .= substr($word, 0, 1);
        }

        // Debug information
        \Log::info("Directorate Name: $directoratename, Extracted Prefix: $prefix");

        return strtolower($prefix);
    }

    // this function is for migrating employees from local auth database
    public function getEmployeesFromLocalHR()
    {
        $insertData = [];
        $avialableEmployees = [];
        $isRecordModified = false;
        $headers = ['Accept' => 'application/json'];
        $employees = Http::get(env('CUSTOM_API_LOCAL_HR_BASE_URL') . 'api/dms/get-employees', $headers)->throw();
        $employees = $employees->json();
        $employeeModel = new Employee();
        log::info('Employee', $employees[0]);
//        return $employees[0];

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
    }

//    This function gets all the directorates of a specified deputy
    public function getDeputyDirectorates(Request $request)
    {
        $deputy_id = $request->deputy_id;
        return (new Directorate())->where('parent_id', $deputy_id)
            ->selectRaw('name_' . lang() . ' as name,id')
            ->get();
    }

//    This function gets all the directorates of a specified deputy
    public function getGeneralDirDirectorates(Request $request)
    {
        $directorate_id = $request->directorate_id;
        return (new Directorate())->where('parent_id', $directorate_id)
            ->selectRaw('name_' . lang() . ' as name,id')
            ->get();
    }

//    this function gets all the employees of specified directorate
    public function getDirectorateUsers(Request $request)
    {
        $directorate_id = $request->directorate_id;
        return (new Employee())->getDirectorateUsers($directorate_id);
    }

    public function getDirectorateEmployees(Request $request)
    {
        $employees = Employee::where('directorate_id', $request->directorate_id)->selectRaw('name,id, CONCAT(name,"-",father_name) AS full_name,father_name,position')->get();
        return $employees;
    }

    public function searchUser(Request $request)
    {
        $keyword = $request->keyword;
        $tracker_id = $request->tracker_id;
        $users = User::where('user_name', 'like', '%' . $keyword . '%')->get();
        return $users;
    }

    public function search(Request $request)
    {
        $type    = $request->type;
        $keyword = $request->keyword;
        if($type === 'external_directorate'){
            return (new ExternalDirectorate())->where('name', 'like', '%' . $keyword . '%')->get()->take(10);
        }
    }

    public static function getArchiveData()
    {
        $headers = ['Accept' => 'application/json'];
        $docs = Http::timeout(100)->get('http://172.30.21.19:8000/api/InDocsAPI/GetInDocs', $headers);
//        $external_dirs = Http::get('http://172.30.21.19:8000/api/OutsideOrganizationsAPI/', $headers);
//        $internal_dirs = Http::get('http://172.30.21.19:8000/api/MofDepartmentsAPI/', $headers);
//        $this->insertMofDepartments(json_decode($internal_dirs, true));
//        $this->insertExternalDirectorates(json_decode($external_dirs, true));

//        log::info('done', $internal_dirs);
//        return response()->json([
//            'status' => 200,
//            'message' => __('general_words.record_saved'),
//        ]);
//        $chunks = $collection->take(100);
//        $data  = $chunks->groupBy('InDocLinkId');
//        $data = $docs;
//        $jsonString = $data;
        $trackers = json_decode($docs, true);
        $collection = collect($trackers);

//        dd($collection->take(100));
//        dd($trackers);
        foreach ($trackers as $doc)
        {
            InDoc::created([
                'id' => $doc['InDocId'],
                'in_num' => $doc['IncomingDocNumber'],
                'in_doc_prefix' => $doc['IncomingDocPrefix'],
                'out_doc_prefix' => $doc['OutCode'],
                'out_num' => $doc['SentDocNumber'],
                'in_date' => $doc['IncomingDate'],
                'out_date' => $doc['SentDocDate'],
                'phone_number' => $doc['SenderPhone'],
                'focal_point_name' => $doc['SenderName'],
                'request_deadline' => '',
                'remark' => $doc['Description'],
                'attachment_count' => $doc['AttachmentsCount'],
                'deadline_id' => '',
                'status_id' => $doc['Status'],
                'deadline_type_id' => 1,
                'security_level_id' => $doc['SecurityLevel'],
                'followup_type_id' => 2,
                'doc_type_id' => $doc['DocumentType'],
                'conclusion' => '',
                'in_out' => '',
                'type' => $doc['SenderHrmisId'] ? 'internal' : 'external',
                'decision_subject' => 'ss',
            ]);
        }
        dd('hi');


        $data     = collect($trackers);
        foreach (($data) as $doc) {
            $document   = Document::create([
               'title'  => $doc['Description'],
               'remark' => $doc['Description'],
                'created_by' => auth()->id(),
            ]);
            $sentDocNo   = $doc['SentDocNumber'];
            $relatedTrackers = $data->filter(function ($item) use ($sentDocNo) {
                preg_match('/(\d+)$/', $item['OutDocLinkId'], $matches);
                $extractedNumericPart = isset($matches[1]) ? $matches[1] : null;
                return $extractedNumericPart == $sentDocNo;
            });
//            dd($relatedTrackers);
            $instance = new self();
            if(count($relatedTrackers)){
                $instance->storeTracker($doc,$document->id);
                foreach ($relatedTrackers as $tracker){
                    $instance->storeTracker($tracker,$document->id);
                }
            }
            else{
                $instance->storeTracker($doc,$document->id);
            }
        }
        dd('hi');
        log::info('done', $data);

    }

    public function storeTracker($tracker, $document_id)
    {
        $securityLevel = SecurityLevel::where('name', $tracker['SecurityLevel'])->first();
        if (!$securityLevel) {
            $securityLevel = SecurityLevel::create([
                'name' => $tracker['SecurityLevel'],
            ]);
        }
        $status = Status::where('name', $tracker['Status'])->first();
        if (!$status) {
            $status = Status::create([
                'name' => $tracker['Status'],
            ]);
        }
        $docType = DocType::where('name', $tracker['DocumentType'])->first();
        if (!$docType) {
            $docType = DocType::create([
                'name' => $tracker['DocumentType'],
            ]);
        }
        $type = '';
        $sender_employee_id = '';
        if ($tracker['SenderHrmisId']) {
            $sender_employee_id = Directorate::where('id', $tracker['SenderHrmisId'])->first()->departmentHead->id;
            $type = 'internal';
        } else {
            $type = 'external';
        }
        $receiver_employee_id = null;
        if ($tracker['DepartmentHrmisId']) {
            $receiver_employee_id = Directorate::where('id', $tracker['DepartmentHrmisId'])->first()->departmentHead->id;
        }
        $checkPoint = Tracker::where('id', $tracker['InDocId'])->first();
        if (!$checkPoint) {
            Tracker::create([
                'document_id' => $document_id,
                'id' => $tracker['InDocId'],
                'sender_employee_id' => $sender_employee_id,
                'sender_directorate_id' => $tracker['SentById'],
                'receiver_employee_id' => $receiver_employee_id,
                'receiver_directorate_id' => $tracker['DepartmentId'],
                'in_num' => $tracker['IncomingDocNumber'],
                'in_doc_prefix' => $tracker['IncomingDocPrefix'],
                'out_doc_prefix' => $tracker['OutCode'],
                'out_num' => $tracker['SentDocNumber'],
                'in_date' => $tracker['IncomingDate'],
                'out_date' => $tracker['SentDocDate'],
                'phone_number' => $tracker['SenderPhone'],
                'focal_point_name' => $tracker['SenderName'],
                'request_deadline' => '',
                'remark' => $tracker['Description'],
                'attachment_count' => $tracker['AttachmentsCount'],
                'deadline_id' => '',
                'status_id' => $status->id,
                'deadline_type_id' => 1,
                'security_level_id' => $securityLevel->id,
                'followup_type_id' => 2,
                'doc_type_id' => $docType->id,
                'conclusion' => '',
                'in_out' => '',
                'type' => $type,
                'decision_subject' => 'ss',
            ]);
        }
    }

    public function insertMofDepartments($internal_dirs)
    {
        foreach ($internal_dirs as $internalDir) {
            if ($internalDir['internal_external'] == 1 && $internalDir['hrmis_id'] == null) {
                $prefix = $result = substr($internalDir['InCode'], 0, -1);
                $directorate = Directorate::where('name_prs', $internalDir['DepartmentName'])->first();
                if (!$directorate) {
                    Directorate::create([
                        'id' => $internalDir['Id'],
                        'name_en' => $internalDir['DepartmentName'],
                        'name_prs' => $internalDir['DepartmentName'],
                        'name_ps' => $internalDir['DepartmentName'],
                        'parent_id' => 0,
                        'prefix' => $prefix,
                    ]);
                }
            }
            if ($internalDir['hrmis_id'] != null && $internalDir['internal_external'] == 1) {
                $directorate = Directorate::where('id', $internalDir['hrmis_id'])->first();
                $prefix = $result = substr($internalDir['InCode'], 0, -1);
                if ($directorate) {
                    $directorate->update([
                        'prefix' => $prefix,
                    ]);
                }
            }
        }
    }

    public function insertExternalDirectorates($directorates)
    {
        foreach ($directorates as $external_dir) {
            if ($external_dir['hrmis_id'] != null || $external_dir['internal_external'] == 1) {
                $directorate = Directorate::where('id', $external_dir['hrmis_id'])->first();
//                $prefix = $result = substr($external_dir['code'], 0, -1);
                if (!$directorate) {
                    $check   = Directorate::where('id', $external_dir['Id'])->first();
                     $latestDir = Directorate::latest()->first();
                    Directorate::create([
                        'id' => $check?$latestDir->id++:$external_dir['Id'],
                        'name_en' => $external_dir['OrganizationName'],
                        'name_prs' => $external_dir['OrganizationName'],
                        'name_ps' => $external_dir['OrganizationName'],
                        'parent_id' => 0,
                        'prefix' => null,
                    ]);
                }
            }
            if ($external_dir['hrmis_id'] == null && $external_dir['internal_external'] == null) {
                $check = ExternalDirectorate::where('id', $external_dir['Id'])->first();
                if (!$check) {
                    ExternalDirectorate::create([
                        'id' => $external_dir['Id'],
                        'name' => $external_dir['OrganizationName'],
                    ]);
                }
            }

        }
    }
}
