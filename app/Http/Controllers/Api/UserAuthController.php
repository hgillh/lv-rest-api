<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
        ]);

        $token = $user->createToken("LaravelRestApi")->accessToken;

        return response()->json(
            [
                "data" => [
                    "type" => "user registered",
                    "message" => "Success",
                    "token" => $token,
                ],
            ],
            200
        );
    }

    /**
     * Login Req
     */
    public function login(Request $request)
    {
        $data = [
            "email" => $request->email,
            "password" => $request->password,
        ];

        if (Auth::attempt($data)) {
            $user = Auth::user();
            $token = $user->createToken("LaravelRestApi")->accessToken;
            return response()->json(["token" => $token], 200);
        } else {
            return response()->json(["error" => "Unauthorised"], 401);
        }
    }

    public function userInfo()
    {
        $user = User::all();
        return response()->json(
            [
                "data" => [
                    "type" => "activities",
                    "message" => "Success",
                    "data" => $user,
                ],
            ],
            200
        );
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->save();
        return response()->json(
            [
                "data" => [
                    "type" => "activities",
                    "message" => "Success",
                    "data" => $user,
                ],
            ],
            200
        );
    }
    public function delete(Request $request, $id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(
            [
                "data" => [
                    "type" => "activities",
                    "message" => "Success",
                    "data" => "deleted!",
                ],
            ],
            200
        );
    }
}