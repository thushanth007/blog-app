<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class MyPostController extends Controller
{
    public function show()
    {
        $posts = Post::with(['commentList' => function ($query) {
                $query->select('id', 'body');
            }])
            ->withCount(['likes', 'commentList'])
            ->where('created_by', Auth::user()->id)
            ->orderByDesc('created_at')
            ->paginate(3);

        $commentableType = Post::class;

        return view('my-post', compact('posts', 'commentableType'));
    }
}
