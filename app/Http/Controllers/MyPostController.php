<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class MyPostController extends Controller
{
    public function show()
    {
        $posts = Post::where('created_by', Auth::user()->id)->orderByDesc('created_at')->paginate(5);

        return view('my-post', compact('posts'));
    }
}
