<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocTypeRequest;
use App\Http\Requests\UpdateDocTypeRequest;
use App\Http\Resources\DocTypeResource;
use App\Models\DocType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DocTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return (new DocType)->getDocumentTypes($request);
        }
        return view('document_types.index');
    }


    public function create()
    {
         return 'doc type create view';
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>   'required',
        ]);
        if($validator->fails()){
           return response()->json([
               'status' => '400',
               'message' => __('general_words.missing_inputs'),
               'errors'=> $validator->messages()
           ]);
        }else{
            $doc_type = new DocType();
            $doc_type->name = $request->name;
            $doc_type->created_by = auth()->user()->id;
            $doc_type->save();
            return response()->json([
                'status' => '200',
                'message'   =>  __('general_words.record_saved'),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DocType $documentType)
    {
        return $documentType;
    }



    public function edit(DocType $documentType)
    {
        return $documentType;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $documentType)
    {
        $recordId  = DocType::find($documentType);
        $recordId->update([
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
    public function destroy(DocType $documentType)
    {
           $deleted = $documentType->delete();
           if($deleted){
            return response()->json([
                'status' => '200',
                'message' => 'Document type deleted successfully'
            ]);
           }
    }
}
