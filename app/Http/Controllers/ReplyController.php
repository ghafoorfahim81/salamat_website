<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $comment_body = json_decode($request->comment_body);
        $comment = new Comment([
            'body' => $comment_body->comment_body,
            'user_id' => auth()->id(),
            'parent_id' => $comment_body->parent_id,
            'tracker_id' =>  $comment_body->tracker_id,
        ]);

        $comment->save();
        $comment->created_at  = miladiToHijriOrJalali(date('Y-m-d H:i:s'));
        if ($request->hasFile('attachment')){
            $file = $request->file('attachment');
            $fullName = $file->getClientOriginalName();
            $originalName   = pathinfo($fullName, PATHINFO_FILENAME);
            $fileExtension  = $file->getClientOriginalExtension();
            $attachmentName = $originalName. '.' . $fileExtension;
            $path = $file->storeAs('public/comments', $attachmentName);

            $store = Attachment::create([
                'table_id' => $comment->id,
                'table_name' => 'comments',
                'assign_name' => 'comment attachment',
                'original_name' => $originalName,
                'file' => $attachmentName,
                'created_by' => auth()->id(),
            ]);

        }
        return response()->json(['message' => 'comment added', 'status' => 200, 'reply' => $comment->load(['user','attachment'])]);

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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment_body = json_decode($request->comment_body);
        $comment      = Comment::findOrFail($id);
        $comment->update([
            'body' => $comment_body->comment_body,
            'user_id' => auth()->id(),
            'parent_id' => $comment_body->parent_id,
            'tracker_id' =>  $comment_body->tracker_id,
        ]);

        if($request->hasFile('attachment')){

            $oldImg  = DB::table('attachments')->where('table_id',$comment->id)->where('table_name','comments')->first();
            if($oldImg){
                $filePath = 'public/comments/' . $oldImg->file;
                unlink(storage_path('app/'.$filePath));
                DB::table('attachments')->where('table_id',$comment->id)->where('table_name','comments')->delete();
            }
            $file = $request->file('attachment');
            $fullName = $file->getClientOriginalName();
            $originalName   = pathinfo($fullName, PATHINFO_FILENAME);
            $fileExtension  = $file->getClientOriginalExtension();
            $attachmentName = $originalName. '.' . $fileExtension;
            $path = $file->storeAs('public/comments', $attachmentName);

            $store = Attachment::create([
                'table_id' => $comment->id,
                'table_name' => 'comments',
                'assign_name' => 'comment attachment',
                'original_name' => $originalName,
                'file' => $attachmentName,
                'created_by' => auth()->id(),
            ]);
        }
        return response()->json(['message' => 'comment update', 'status' => 200, 'comment' => $comment->load(['user','attachment','replies'])]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($commentId, $replyId)
    {
        try {
            // Find the comment and the reply
            $comment = Comment::findOrFail($commentId);
            $reply = $comment->replies()->findOrFail($replyId);

            // Delete the reply
            $reply->delete();

            return response()->json(['message' => 'Reply deleted successfully', 'status' => 200]);
        } catch (\Exception $e) {
            // Handle the error, e.g., return an error response
            return response()->json(['message' => 'Error deleting reply', 'status' => 500], 500);
        }
    }
}
