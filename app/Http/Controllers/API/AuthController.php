<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    
        public function login(Request $request){
                     $validate_login_User = Validator::make(
                        $request->all(),
                [
                'email' => 'required|email',
                'password' => 'required'  
            ]
            );

                 if($validate_login_User->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Authentication Error',
                    'errors' => $validate_login_User->errors()->all()
                ],404);
            }

            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $authUser = Auth::User();
                  return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $authUser->createToken("API Token")->plainTextToken,
                'token_type' => 'Bearer'
            ],200);

            }else{
                return response()->json([
                    'status' => false,
                    'message'=> 'Email or Password does not match' 
                ],401);
            }


    }

        public function logout(Request $request){

            $user = $request->User();
            $user->tokens()->delete();

            return response()->json([
                'status' => true,
                'message' => 'User Logged Out Successfully'
            ],200);

    }
}