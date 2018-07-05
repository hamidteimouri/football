<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    protected $status_success = 200;
    protected $bad_request = 400;

    public function register()
    {
        $request = request()->all();

        $validate = validator($request, [
            'name' => 'required|max:128',
            'email' => 'required|email|unique:users|max:128',
            'password' => "required|min:6|max:128"
        ]);

        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], $this->bad_request);
        }

        $user = new User();

        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = $request['password'];  # password will hashed by mutator
        $user->save();

        return response()->json(['Success'], $this->status_success);

    }

    public function login()
    {
        $request = request()->all();
        //validate
        $validate = validator($request, [
            'email' => 'required|email|max:128',
            'password' => "required|min:6|max:128"
        ]);
        if ($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors()
            ], $this->bad_request);
        }

        // login
        if (auth()->attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $user = auth()->user();
            $token = $user->createToken('MyWebsite')->accessToken;
            return response()->json([
                'token' => $token
            ]);
        } else {
            return response()->json([
                'error' => 'Something wrong...'
            ]);
        }

    }
}
