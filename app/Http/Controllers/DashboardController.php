<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class DashboardController extends Controller
{
    public function show()
    {
        $posts = Post::with(['commentList' => function ($query) {
                $query->select('id', 'body');
            }])
            ->withCount(['likes', 'commentList'])
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->paginate(3);

        $commentableType = Post::class;

        return view('dashboard', compact('posts', 'commentableType'));
    }
}
