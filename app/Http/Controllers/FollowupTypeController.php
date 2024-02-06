<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFollowupTypeRequest;
use App\Http\Requests\UpdateFollowupTypeRequest;
use App\Http\Resources\FollowupTypeResource;
use App\Models\FollowupType;
use App\Models\SecurityLevel;
use FontLib\OpenType\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FollowupTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return (new FollowupType)->getFollowupTypes($request);
        }
        return view('followup-types.index');
    }


    public function create()
    {
        return 'followup type create view';
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
            $followup_type = new FollowupType();
            $followup_type->name = $request->input('name');
            $followup_type->created_by = auth()->user()->id;
            $followup_type->save();
            return response()->json([
                'status' => 200,
                'message' => __('general_words.record_saved'),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FollowupType $followup_type)
    {
        return $followup_type;
    }



    public function edit(FollowupType $followupType)
    {
        return $followupType;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $followupType)
    {
        $typeId  = FollowupType::find($followupType);
        $typeId->update([
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
    public function destroy(FollowupType $followup_type)
    {
           $deleted = $followup_type->delete();
           if($deleted){
            return response()->json([
                'status' => '200',
                'message' => 'Followup type deleted successfully'
            ]);
           }
    }
}
