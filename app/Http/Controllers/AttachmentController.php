<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttachmentController extends Controller
{
    protected $attachement;

    public function __construct(Attachment $attachement)
    {
        $this->attachement  = $attachement;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        try{
        $attachment = '';
        $original_name = '';
            DB::beginTransaction();
        if ($request->hasFile('attachment')){
            $file     = $request->file('attachment');
            $fullName = $file->getClientOriginalName();
            $filename = pathinfo($fullName,PATHINFO_FILENAME);
            $original_name = $filename;
            $fileExtension = $file->getClientOriginalExtension();
            $attachment = $filename.'-'.time().'.'.$fileExtension;
            $path = $file->storeAs('public/'.$request->table_name.'/',$attachment);
        }
        $store  = $this->attachement->create([
            'table_id'      => $request->table_id,
            'table_name'    => $request->table_name,
            'assign_name'   => ($request->file_name!=null)?$request->file_name:$original_name,
            'original_name' => $original_name,
            'file'          => $attachment
        ]);
            $lastFile  = $this->attachement->orderBy('id','desc')->first();
            DB::commit();
            return response()->json([
                'status'=> 200,
                'lastFile'=>$lastFile,
                'message'=> __('general_words.upload_success'),
            ]);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'status'=> 400,
                'message'=> __('general_words.something_went_wrong'),
            ]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request,$id)
    {
        $attachement   = $this->attachement->where('id',$id)->first();
        $file    = substr($attachement->file, 0, strpos($attachement->file, '.'));
        return response()->download(storage_path('app/public/'.$attachement->table_name.'/'.$attachement->file));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

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
