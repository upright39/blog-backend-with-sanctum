<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //


    public function addPost(Request $request)
{
    $request->validate([
        'name'=>'required|string',
        'content'=>'required|min:4',
    ]);
    

    $post = new Post();
    $post->name = $request->name;
    $post->content = $request->content;
    $post->save();
    
    return response([
            'status'=> 200,
            'post'=> $post,
        ]);


}

public function Post(Request $request)
{
 

    $allPost = Post::all();

    
    return response([
            'status'=> 200,
            'post'=> $allPost,
        ]);


}

}
