<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::withCount(['likes', 'commentList'])->where('status', 1)->orderByDesc('created_at')->paginate(3);

        return view('home', compact('posts'));
    }
}
