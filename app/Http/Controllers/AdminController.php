<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class AdminController extends Controller
{
    public function show()
    {
        $posts = Post::orderByDesc('created_at')->paginate(3);

        return view('admin.dashboard', compact('posts'));
    }
}
