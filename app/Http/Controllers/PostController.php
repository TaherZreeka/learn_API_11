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

    public function edit_post(Request $request){
         $validated=Validator::make($request->all(),[
            'title' => 'required|string',
            'content' => 'required|string',
            'post_id' => 'required|integer',
        ]);

        if($validated->fails()){
            return response()->json($validated->errors(),403);
        }


        try {
           $post_data=Post::find($request->post_id);

           $Update_Post=$post_data->update([
                'title'=>$request->title,
                'content'=>$request->content,
           ]);
            // Return a success response with the token
            return response()->json([
                'message' => 'Post Edited successfully',
                'update post' => $Update_Post,
            ],200);
        } catch (\Exception $exception) {
           return response()->json(['error'=>$exception->getMessage()]);
        }
    }
     public function edit_post_id(Request $request,$id){
         $validated=Validator::make($request->all(),[
            'title' => 'required|string',
            'content' => 'required|string',
            'post_id' => 'required|integer',
        ]);

        if($validated->fails()){
            return response()->json($validated->errors(),403);
        }


        try {
           $post_data=Post::find($id);

           $Update_Post=$post_data->update([
                'title'=>$request->title,
                'content'=>$request->content,
           ]);
            // Return a success response with the token
            return response()->json([
                'message' => 'Post Edited successfully',
                'update post' => $Update_Post,
            ],200);
        } catch (\Exception $exception) {
           return response()->json(['error'=>$exception->getMessage()]);
        }
    }
    public function getAllPost(){
        try {

            $posts=Post::all();
            return response()->json([
                'posts'=>$posts
            ],200);
        } catch (\Exception $exception) {
            return response()->json(['error'=>$exception->getMessage()]);
        }
    }
    public function getPost($post_id){
        // $posts = Post::with('comment', 'user')->where('id', $post_id)->first();

        try {
            $post = Post::with('comments', 'user') // Corrected relationship names
                    ->where('id', $post_id)   // Removed trailing space
                    ->first();

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        return response()->json(['post' => $post], 200);
        } catch (\Exception $exception) {
            return response()->json(['error'=>$exception->getMessage()]);
        }
    }

    public function delete_post(Request $request, $id)
{
    // Validate that the post ID is provided and is an integer
    $validated = Validator::make(['id' => $id], [
        'id' => 'required|integer|exists:posts,id',
    ]);

    if ($validated->fails()) {
        return response()->json($validated->errors(), 403);
    }

    try {
        // Find the post by ID
        $post = Post::find($id);

        // Check if the post exists
        if (!$post) {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }

        // Ensure the authenticated user owns the post (optional but recommended for security)
        if ($post->user_id !== auth()->user()->id) {
            return response()->json([
                'message' => 'You do not have permission to delete this post',
            ], 403);
        }

        // Delete the post
        $post->delete();

        // Return a success response
        return response()->json([
            'message' => 'Post deleted successfully',
        ], 200);
    } catch (\Exception $exception) {
        // Return an error response if something goes wrong
        return response()->json([
            'error' => $exception->getMessage(),
        ], 500);
    }
}
}
