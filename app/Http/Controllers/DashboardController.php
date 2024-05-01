<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class DashboardController extends Controller
{
    public function show()
    {
        $posts = Post::select('id', 'content', 'image', 'created_by', 'created_at', 'status')
            ->withCount(['likes', 'commentList'])
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->paginate(3);

        foreach ($posts as $post) {
            $comments = Comment::select('id', 'post_id', 'body', 'user_id')
                ->where('post_id', $post->id)
                ->get();

            $post->comments = $comments;
        }

        $commentableType = Post::class;

        return view('dashboard', compact('posts', 'commentableType'));
    }
}
