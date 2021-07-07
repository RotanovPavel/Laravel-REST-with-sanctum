<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{

    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {

        $fields = $request->validate([
           'name' => ['required', 'string'],
           'email' => ['required', 'string', 'unique:users', 'email'],
           'phone' => ['required', 'digits:12'],
           'password' => ['required', 'string', 'min:6' , 'confirmed'],
        ]);

        $user = User::create([
           'name' => $fields['name'],
           'email' => $fields['email'],
           'phone' => $fields['phone'],
           'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('appToken')->plainTextToken;

        $response = [
          'user' => $user,
          'token' => $token
        ];

        return response($response, 201);
    }


    /**
     * Logout and destroy token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
          'message' => 'Logged out'
        ];
    }

    public function login(Request $request) {

        $fields = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad credentials'
            ], 401);
        }

        $token = $user->createToken('appToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
}
