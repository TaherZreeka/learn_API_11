<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    //   Register
    public function register(Request $request){
      // Perform validation using the validate() method
        // $validated = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|unique:users|max:255',
        //     'password' => 'required|string|min:6|confirmed',
        // ]);

        $validated=Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);


        if($validated->fails()){
            return response()->json($validated->errors(),403);
        }
        try {
             // Create the user with the validated data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate and return the authentication token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token,'user'=>$user]);
        } catch (\Exception $exception) {
            return response()->json(['error'=>$exception->getMessage()]);
        }
    }



    // Login
   public function login(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string'
    ]);

    // Extract the credentials from the request
    $credentials = $request->only('email', 'password');

    // Attempt to authenticate the user
    if (!auth()->attempt($credentials)) {
        // Return an error response if authentication fails
        return response()->json(['error' => 'Invalid Credentials'], 401);
    }
    $user=User::where('email',$request->email)->firstOrFail();
    // Generate a token for the authenticated user (for API-based authentication)
    $token = $user->createToken('auth_token')->plainTextToken;

    // Return a success response with the token
    return response()->json([
        'message' => 'Authenticated successfully',
        'token' => $token,
        'user' =>$user
    ]);
}

    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();
         // Return a success response with the token
    return response()->json([
        'message' => 'User Has Been logged Out successfully',
    ]);
    }

    }
