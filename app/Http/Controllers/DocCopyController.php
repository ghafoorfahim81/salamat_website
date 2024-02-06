<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocCopyRequest;
use App\Http\Requests\UpdateDocCopyRequest;
use App\Http\Resources\DocCopyResource;
use App\Models\DocCopy;
use Illuminate\Http\Request;

class DocCopyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        return DocCopy::all();
    }



    public function create() 
    {
        return 'doc copy create view';
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocCopyRequest $request)
    {
        $doc_copies = DocCopy::create($request->validated());
        return $doc_copies;
    }

    /**
     * Display the specified resource.
     */
    public function show(DocCopy $doc_copy)
    {
        return $doc_copy;
    }



    public function edit(DocCopy $doc_copy)
    {
        return $doc_copy;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocCopyRequest $request, DocCopy $doc_copy)
    {
        $doc_copy->update($request->validated());
        return $doc_copy;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocCopy $doc_copy)
    {
           $deleted = $doc_copy->delete();
           if($deleted){
            return response()->json([
                'status' => '200',
                'message' => 'DocCopy type deleted successfully'
            ]);
           }
    }
}
