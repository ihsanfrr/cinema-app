<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ], 401);
        }

        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];
        
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'username atau password salah'
            ], 401);
        } 

        Auth::user()->update([
            'remember_token' => bcrypt($request->username)
        ]);

        return response()->json([
            'message' => 'login berhasil',
            'username' => Auth::user()->username,
            'token' => Auth::user()->remember_token
        ], 200);
    }

    public function logout(Request $request){
        $user = User::where('remember_token', $request->token)->first();
        
        if (!empty($request->token) && $user) {
            Auth::logout();

            $user->update([
                'remember_token' => null
            ]);

            return response()->json([
                'message' => 'logout berhasil'
            ], 200);
        } else {
            return response()->json([
                'message' => 'unauthorized user'
            ], 401);
        }
    }
}
