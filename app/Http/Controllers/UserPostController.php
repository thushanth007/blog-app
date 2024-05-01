<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\User;

class UserPostController extends Controller
{
    public function show($id)
    {
        $username = User::find($id)->name;
        $posts = Post::select('id', 'content', 'image', 'created_by', 'created_at', 'status')
            ->withCount(['likes', 'commentList'])
            ->where('created_by', $id)
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

        return view('user-post', compact('posts', 'commentableType','username'));
    }

    public function view($id)
    {
        $posts = Post::select('id', 'content', 'image', 'created_by', 'created_at', 'status')
            ->withCount(['likes', 'commentList'])
            ->where('id', $id)
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->paginate(1);

        foreach ($posts as $post) {
            $comments = Comment::select('id', 'post_id', 'body', 'user_id')
                ->where('post_id', $post->id)
                ->get();

            $post->comments = $comments;
        }

        $commentableType = Post::class;

        return view('view-post', compact('posts', 'commentableType'));
    }
}


