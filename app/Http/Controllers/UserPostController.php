<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class UserPostController extends Controller
{
    public function show($id)
    {
        $posts = Post::where('created_by', Auth::user()->id)->where('status', 1)->orderByDesc('created_at')->paginate(5);
        $commentableType = Post::class;
        $commentableId = $posts->isEmpty() ? null : $posts->first()->id;
        return view('user-post', compact('posts', 'commentableType' , 'commentableId'));
    }
}
