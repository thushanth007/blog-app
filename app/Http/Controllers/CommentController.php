<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Notifications\NewCommentNotification;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->commentable_id = $request->commentable_id;
        $comment->user_id = auth()->id();
        $comment->body = $request->body;
        $comment->commentable_type = $request->commentable_type;
        $comment->save();

        $post = Post::find($request->commentable_id);
        if ($post && $post->createdBy) {
            $notification = new NewCommentNotification(auth()->user()->name, $post->title, $post->id);
            $post->createdBy->notify($notification);
        }

        return response()->json(['message' => 'Comment created successfully', 'comment' => $comment]);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
