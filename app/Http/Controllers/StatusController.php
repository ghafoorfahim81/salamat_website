<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatusRequest;
use App\Http\Resources\StatusResource;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return (new Status)->getStatuses($request);
        }
        return view('document_statuses.index');
    }


    public function create()
    {
        return view('document_statuses.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>  '400',
                'message' => __('general_words.missing_inputs'),
                'errors'=> $validator->messages()
            ]);
        }else{
            $document = new Status();
            $document->name = $request->input('name');
            $document->created_by = auth()->user()->id;
            $document->save();
            return response()->json([
                'status' => 200,
                'message' => __('general_words.record_saved'),
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        return $status;
    }



    public function edit(Status $status)
    {
        return $status;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $status)
    {
        // return $request;
       $statusFind  = Status::find($status);
       $statusFind->update([
           'name' =>$request->name
       ]);
       return response()->json([
           'status' => '200',
           'message'   =>  __('general_words.record_updated'),
       ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
           $deleted = $status->delete();
           if($deleted){
            return response()->json([
                'status' => '200',
                'message' => 'Status type deleted successfully'
            ]);
           }
    }
}
