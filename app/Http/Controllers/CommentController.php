<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function postComment(Request $request){
             $validated=Validator::make($request->all(),[
            'post_id' => 'required|integer',
            'comment' => 'required|string',
            // 'user_id' => 'required|integer',
        ]);

        if($validated->fails()){
            return response()->json($validated->errors(),403);
        }

        try {
            $comment=new Comment();
            $comment->post_id=$request->post_id;
            $comment->comment=$request->comment;
            $comment->user_id=auth()->user()->id;
           $comment->save();

           // Return a success response with the token
            return response()->json([
                'message' => 'Comment Added successfully',
            ],200);

        } catch (\Exception $exception) {
             return response()->json(['error'=>$exception->getMessage()]);
        }
    }
     public function getAllComment(){
        try {

            $comments=Comment::all();
            return response()->json([
                'comments'=>$comments
            ],200);
        } catch (\Exception $exception) {
            return response()->json(['error'=>$exception->getMessage()]);
        }
    }
}
