<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
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
            'username' => 'required',
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
            'email' => 'required|string',
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

    // public function getUserProfile($user_id){
    //     $userProfile = UserProfile::find($user_id);
    //     $user = $userProfile->user;

    //     return $user;
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

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User  Profile Tidak ditemukan'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User Dihapus']);
    }

    // public function destroy($id)
    // {
    //     try {
    //         // Find the user by ID along with their avatars
    //         $user = User::with('avatars')->findOrFail($id);

    //         // Delete the avatars associated with the user
    //         // $user->avatar->each->delete();
    //         $user->profile->each->delete();

    //         // Delete the user
    //         $user->delete();

    //         return response()->json(['message' => 'User and associated avatars deleted successfully']);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'An error occurred'], 500);
    //     }
    // }
}
