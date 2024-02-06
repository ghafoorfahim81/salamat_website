<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeadlineRequest;
use App\Http\Requests\UpdateDeadlineRequest;
use App\Http\Resources\DeadlineResource;
use App\Models\Deadline;
use Illuminate\Http\Request;

class DeadlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $docTypeId = $request->input('doc_type_id');
        $securityLevelId = $request->input('security_level_id');

        $deadline = (new Deadline())::where('doc_type_id', $docTypeId)
            ->where('security_level_id', $securityLevelId)
            ->first();
        return response()->json(['days' => $deadline->days]);
    }




    public function create()
    {
        return 'deadline create view';
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeadlineRequest $request)
    {
        $deadline = Deadline::create($request->validated());
        return $deadline;
    }

    /**
     * Display the specified resource.
     */
    public function show(Deadline $deadline)
    {
        return $deadline;
    }


    public function edit( Deadline $deadline)
    {
        return $deadline;
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateDeadlineRequest $request, Deadline $deadline)
    {
        $deadline->update($request->validated());
        return $deadline;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deadline $deadline)
    {
           $deleted = $deadline->delete();
           if($deleted){
            return response()->json([
                'status' => '200',
                'message' => 'Deadline type deleted successfully'
            ]);
           }
    }
}
