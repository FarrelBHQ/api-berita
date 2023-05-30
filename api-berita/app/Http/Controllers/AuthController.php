<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $message = [
            'required' => 'This field must be filled',
            'username.unique' => 'This username has already been taken',


        ];

        $request->validate([
            'username' => 'required|unique:users',
            'firstname' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ], $message);

        $user = User::create([
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => $request->username,'telah terdaftar',
            'data' => $user
        ]);

    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if(! $user || ! Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['these credentials does not match our records.']
            ], 404);
        }

        return $user->createToken('token')->plainTextToken;

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response([
            'message' => 'Logged Out'
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'status' => 'Success',
            'data' => $request->user()
        ]);
    }

    public function profileEdit(Request $request, $user_id)
    {
        $user = User::where('id', $user_id)->first();
        if (! $user) {
            return response([
                'message' => 'Akun Tak Ada'
            ]); 
        }

        $user->update([
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
        ]);

        return response()->json([
            'status' => 'Success',
            'data' => $user
        ], 200);
    }

    public function profileDelete($user_id)
    {
        $user = User::where('id', $user_id)->first();

        if (! $user) {
            return response([
                'message' => 'Akun Tak Ada'
            ]); 
        }

        $user->delete();

        return response()->json([
            'status' => 'Success',
            'message' => $user->username, 'berhasil dihapus'
        ], 200);

    }

    public function showListUser()
    {
        $listUser = User::all();
        return response()->json($listUser);
    }
}
