<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function add_new_post(Request $request){
         $validated=Validator::make($request->all(),[
            'title' => 'required|string',
            'content' => 'required|string',
            // 'user_id' => 'required|integer',
        ]);

        if($validated->fails()){
            return response()->json($validated->errors(),403);
        }


        try {
           $post =new Post();
           $post->title=$request->title;
           $post->content=$request->content;
           $post->user_id=auth()->user()->id;
           $post->save();
            // Return a success response with the token
            return response()->json([
                'message' => 'Post Added successfully',
            ],200);
        } catch (\Exception $exception) {
           return response()->json(['error'=>$exception->getMessage()]);
        }
    }
}