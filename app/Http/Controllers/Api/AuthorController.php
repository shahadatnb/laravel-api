<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Author;

class AuthorController extends Controller
{
    // REGISTER METHOD - POST
    public function register(Request $request)
    {
        // validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:authors",
            "password" => "required|confirmed",
            "phone_no" => "required"
        ]);

        // create data
        $author = new Author();

        $author->name = $request->name;
        $author->email = $request->email;
        $author->phone_no = $request->phone_no;
        $author->password = bcrypt($request->password);

        // save data and send response
        $author->save();

        return response()->json([
            "status" => 1,
            "message" => "Author created successfully"
        ]);
    }

    // LOGIN METHOD - POST
    public function login(Request $request)
    {
        // validation
        $login_data = $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        // $data = Author::where('email', $login_data['email'])
        //     ->where('password', bcrypt($login_data['password']))
        //     ->first();

        // return response()->json([$data]);

        // validate author data
        if(!auth()->attempt($login_data)){

            return response()->json([
                "status" => false,
                "message" => "Invalid Credentials"
            ]);
        }

        // token
        $token = auth()->user()->createToken("auth_token")->accessToken;

        // send response
        return response()->json([
            "status" => true,
            "message" => "Author Logged in successfully",
            "access_token" => $token
        ]);
    }

    // PROFILE METHOD - GET
    public function profile()
    {
        $user_data = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "User data",
            "data" => $user_data
        ]);
    }

    // LOGOUT METHOD - POST
    public function logout(Request $request)
    {
        // get token value
        $token = $request->user()->token();

        // revoke this token value
        $token->revoke();

        return response()->json([
            "status" => true,
            "message" => "Author logged out successfully"
        ]);
    }
}
