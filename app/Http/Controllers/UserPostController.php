<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class UserPostController extends Controller
{
    public function show($id)
    {
        $posts = Post::where('created_by', $id)->orderByDesc('created_at')->paginate(5);

        return view('user-post', compact('posts'));
    }
}
