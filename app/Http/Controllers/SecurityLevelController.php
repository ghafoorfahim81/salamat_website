<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSecurityLevelRequest;
use App\Http\Requests\UpdateSecurityLevelRequest;
use App\Http\Resources\SecurityLevelResource;
use App\Models\SecurityLevel;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SecurityLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return (new SecurityLevel)->getSecurityLevels($request);
        }
        return view('security_levels.index');
   }


    public function create()
    {
        return view('security_levels.create');
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
            $security_level = new SecurityLevel();
            $security_level->name = $request->input('name');
            $security_level->created_by = auth()->user()->id;
            $security_level->save();
            return response()->json([
                'status' => 200,
                'message' => __('general_words.record_saved'),
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(SecurityLevel $security_level)
    {
        return $security_level;
    }


    public function edit(SecurityLevel $security_level)
    {
        return $security_level;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $security_level)
    {
        $security_levelFind  = SecurityLevel::find($security_level);
        $security_levelFind->update([
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
    public function destroy(SecurityLevel $security_level)
    {
           $deleted = $security_level->delete();
           if($deleted){
            return response()->json([
                'status' => '200',
                'message' => 'Security Level deleted successfully'
            ]);
           }
    }
}
