<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Register a new user.
     * method: POST
     * http://localhost:8000/api/register
     */
    
     public function register(Request $request){
        $validator = validator($request->all(), [
            'name' => 'required| min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'sometimes|in:admin,user'
        ]);

        if($validator->fails()){
            return response()->json([
                'ok' => false,
                'message' => 'Registration Failed',
                'errors' => $validator->errors()
            ], 400);
        }
        
        $user = User::create($validator->validated());
        $user->token = $user->createToken('auth-api')->accessToken;

        return response()->json([
            'ok' => true,
            'message' => 'Registration Success',
            'data' => $user
        ], 201);

     }

     /**
      * Log in a User
      * method: POST
      * http://localhost:8000/api/login
      */

      public function login(Request $request){
        $validator = validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'ok' => false,
                'message' => 'Login Failed',
                'errors' => $validator->errors()
            ], 400);
        }

        if(auth()->attempt($validator->validated())){
            $user = auth()->user();
            $user->token = $user->createToken('auth-api')->accessToken; 
            return response()->json([
                'ok' => true,
                'message' => 'Login Success',
                'data' => $user
            ], 200);
        }

        return response()->json([
            'ok' => false,
            'message' => 'Login Failed',     
            'errors' => 'Invalid Credentials'       
        ], 401);

    }
        /**
         * checkToken
         * method: GET
         * http://localhost:8000/api/checkToken
         */

         public function checkToken(Request $request){
            return response()->json([
                'ok' => true,
                'message' => 'Token is Valid',
                'data' => $request->user()
            ], 200);
         }
           
         /**
          * Logout A User
          * method: POST
          * http://localhost:8000/api/logout
          */

          public function logout(Request $request){
            $request->user()->token()->revoke();
            return response()->json([
                'ok' => true,
                'message' => 'Logout Success'
            ], 200);
          }

          /**
           * Search Function
           * method: POST
           * http://localhost:8000/api/search
           */

           public function search(Request $request){
            $validator = validator($request->all(), [
                'search' => 'required'
            ]);

           
            if($validator->fails()){
                return response()->json([
                    'ok' => false,
                    'message' => 'Search Failed',
                    'errors' => $validator->errors()
                ], 400);
            }  

            $users = User::where('name', 'like', '%'.$validator->validated()['search'].'%')->get();



            return response()->json([
                "ok" => true,
                "message" => "Find successfully",
                "data" => $users
            ], 200);
    }
}