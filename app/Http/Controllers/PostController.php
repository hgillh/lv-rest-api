<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //Save a new post
    public function create(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',

        ]);

        $post = Post::create([
            "title" => $request->title,
            "description" => $request->description,
            "user_id" => Auth::user()->id
        ]);

        return response()->json(
            [
                "data" => [
                    "type" => "post created",
                    "message" => "Success",
                    "post" => $post->title,
                ],
            ],
            200
        );

    }
}
