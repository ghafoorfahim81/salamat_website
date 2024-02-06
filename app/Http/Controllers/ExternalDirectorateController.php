<?php

namespace App\Http\Controllers;

use App\Models\ExternalDirectorate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExternalDirectorateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $externalDirectorate;
    public function __construct(ExternalDirectorate $externalDirectorate){
        $this->externalDirectorate = $externalDirectorate;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->externalDirectorate->getExternalDirectorates($request);
        }
        return view('external_directorates.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $store = $this->externalDirectorate->create([
                'name' => $request->name,
                'created_by' => auth()->user()->id,
            ]);

            if ($store) {
                DB::commit(); // Commit the transaction if everything is successful
                return response()->json([
                    'status' => 200,
                    'message' => __('general_words.record_saved'),
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction if an exception occurs

            return response()->json([
                'status' => 500,
                'message' => __('general_words.error_saving_record'),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExternalDirectorate $externalDir)
    {
        return $externalDir;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $externalDir)
    {
        try {
            DB::beginTransaction();

            $recordId = $this->externalDirectorate->findOrFail($externalDir); // Using findOrFail to throw an exception if the record is not found

            $recordId->update([
                'name' => $request->name,
            ]);

            DB::commit(); // Commit the transaction if everything is successful

            return response()->json([
                'status' => 200,
                'message'   =>  __('general_words.record_updated'),
            ]);
        } catch (ModelNotFoundException $e) {
            DB::rollback(); // Rollback the transaction if the record is not found

            return response()->json([
                'status' => 404,
                'message' => 'Record not found',
            ]);
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction if an exception occurs

            return response()->json([
                'status' => 500,
                'message' => 'Error updating the record',
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $externalDir)
    {
        try {
            DB::beginTransaction();

            $recordId = $this->externalDirectorate->findOrFail($externalDir);

            $recordId->delete();

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Record deleted successfully',
            ]);
        } catch (ModelNotFoundException $e) {
            DB::rollback();

            return response()->json([
                'status' => 404,
                'message' => 'Record not found',
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 500,
                'message' => 'Error deleting the record',
            ]);
        }

    }
}
