<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class DashboardController extends Controller
{
    public function show()
    {
        $posts = Post::orderByDesc('created_at')->paginate(3);

        return view('dashboard', compact('posts'));
    }
}
