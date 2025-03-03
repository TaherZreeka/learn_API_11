<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LikesController extends Controller
{
    public function add_like(Request $request){
         $validated=Validator::make($request->all(),[
            'post_id' => 'required|integer',
        ]);

        if($validated->fails()){
            return response()->json($validated->errors(),403);
        }


        try {
           $like =new Like();
           $like->post_id=$request->post_id;
           $like->user_id=auth()->user()->id;
           $like->save();
            // Return a success response with the token
            return response()->json([
                'message' => 'Like Added successfully',
            ],200);
        } catch (\Exception $exception) {
           return response()->json(['error'=>$exception->getMessage()]);
        }
    }
}
