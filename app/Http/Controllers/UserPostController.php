<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class UserPostController extends Controller
{
    public function show($id)
    {
        $posts = Post::with(['commentList' => function ($query) {
                $query->select('id', 'body');
            }])
            ->withCount(['likes', 'commentList'])
            ->where('created_by', Auth::user()->id)
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->paginate(3);

        $commentableType = Post::class;

        return view('user-post', compact('posts', 'commentableType'));
    }
}
