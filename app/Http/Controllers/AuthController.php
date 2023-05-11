<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api', ['except' =>  ['login', 'register']]);
    }
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|string|email',
            'password'=>'required|string|min:6'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password'=>bcrypt($request->password)]
        ));
        return response()->json([
            'message'=>'User successfully registered',
            'user'=>$user
        ], 201);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password'=>'required|string|min:6'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        if(!$token=auth()->attempt($validator->validated())){
            return response()->json(['error'=>'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
        //return $token;
    }

    public function createNewToken($token){
        try {
            $guardConfig = config('auth.defaults.guard');
            $ttl = config("auth.guards.$guardConfig.expiration") * 60;
            return response()->json([
                'accessToken'=> $token,
                'token_type'=> 'Bearer',
                'expires_in'=> $ttl,
            ]);
        } catch (\Exception $e) {
            // Handle the error by logging it or returning an error response
            logger()->error('Error creating new token: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create new token'], 500);
        }
    }
    
    // public function refresh($token)
    // {
    //     return response()->json([
    //         'refreshToken'=> $token,
    //         'token_type'=> 'Bearer'
    //     ]);
    // }

    public function profile(){
        return response()->json(auth()->user());
    }
    public function logout(){
        auth()->logout();
        return response()->json([
            'message'=>'User Logout'
        ]);
    }
}
