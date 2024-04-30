<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function show()
    {
        $posts = Post::where('status', 1)->orderByDesc('created_at')->paginate(5);
        $commentableType = Post::class;
        $commentableId = $posts->isEmpty() ? null : $posts->first()->id;
        return view('dashboard', compact('posts', 'commentableType' , 'commentableId'));
    }
}
