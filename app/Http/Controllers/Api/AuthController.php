<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens; 
class AuthController extends Controller
{
    public function createUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function login(Request $request){

        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|min:8' 
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if($user){
    
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json([
                    'message' => 'Connected Successfully',
                    'token' => $token
                ]);
            }else{
                return response()->json([
                    'message' => 'Invalid Credentials',"val"=>$request->all()
                ], 401);
            }
    
        }else{
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }
    }
    public function logout()
    {
        /** @disregard P1013 [tokens function exists and working] **/
        auth()->user()->tokens()->delete();

        return [
            'message' => 'logged out'
        ];
    }
    
}