<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Notifications\NewCommentNotification;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->post_id = $request->post_id;
        $comment->user_id = auth()->id();
        $comment->body = $request->body;
        $comment->commentable_type = $request->commentable_type;
        $comment->save();

        $comment->user_name = User::find(auth()->id())->name;
        $comment->comment_count = Comment::where('post_id', $request->post_id)->count();

        $post = Post::find($request->post_id);
        if ($post && $post->createdBy) {
            $notification = new NewCommentNotification(auth()->user()->name, $post->title, $post->id);
            $post->createdBy->notify($notification);
        }

        return response()->json(['comment' => $comment]);
    }

    public function destroy($id)
    {
        $post_id = Comment::findOrFail($id)->post_id;
        $comment = Comment::findOrFail($id);
        $comment->delete();

        $comment_count = Comment::where('post_id', $post_id)->count();

        return response()->json(['comment' => $comment_count, 'post_id' => $post_id]);
    }
}
