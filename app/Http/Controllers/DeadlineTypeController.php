<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeadlineTypeRequest;
use App\Http\Requests\UpdateDeadlineTypeRequest;
use App\Http\Resources\DeadlineTypeResource;
use App\Models\DeadlineType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeadlineTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DeadlineType::all();
    }


    public function create()
    {
        return 'deadline type create view';
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'name' => 'required',
            ]);
        if($validator->fails()){
            return response()->json([
               'status' => '400',
               'message' =>  __('general_words.missing_inputs'),
               'error' => $validator->messages()
            ]);
        }else{
            $deadline_type = new DeadlineType();
            $deadline_type->name = $request->input('name');
            $deadline_type->created_by = auth()->user()->id;
            $deadline_type->save();
            return response()->json([
                'status' => '200',
                'message' => __('general_words.record_saved'),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DeadlineType $deadline_type)
    {
        return $deadline_type;
    }


    public function edit(DeadlineType $deadline_type)
    {
        return $deadline_type;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeadlineTypeRequest $request, DeadlineType $deadline_type)
    {
        $deadline_type->update($request->validated());
        return $deadline_type;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeadlineType $deadline_type)
    {
           $deleted = $deadline_type->delete();
           if($deleted){
            return response()->json([
                'status' => '200',
                'message'   =>  __('general_words.record_updated'),
            ]);
           }
    }
}
