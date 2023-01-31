<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\validator;


class AuthController extends Controller
{


    public function register(Request $request)
    {
        $validator = validator::make($request->all(), [
            'first_name' => 'required|string|max:255|min:4',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|confirmed',
        ]);


        if ($validator->fails()) {
            return response()->json([
                "error_messages" => $validator->errors(),
            ]);
        } else {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response([
                'status' => 200,
                'user_name' => $user->first_name,
                'token' => $user->createToken('Api Token of' . $user->name)->plainTextToken,
                'message' => 'Registerd Successfully'
            ], 200);
        }
    }



    public function login(Request $request)
    {
        $validator = validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                "error_messages" => $validator->errors(),
            ]);
        } else {

            //check the email
            $user = User::where('email', $request->email)->first();

            //chech password
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Bad credentials, email or password not correct',
                ]);
            } else {

                return response([
                    'status' => 200,
                    'user_name' => $user->first_name,
                    'token' => $user->createToken('Api Token of' . $user->name)->plainTextToken,
                    'message' => 'Logged in Successfully',
                ]);
            }
        }
    }



    public function logout(Request $request)
    {

        auth()->user()->tokens()->delete();

        return response()->json(
            [
                'status' => 200,
                'message' => 'Logged Out Successfully'
            ]
        );
    }
}
