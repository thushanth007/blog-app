<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    public function store($id)
    {
        Like::create([
            'post_id' => $id,
            'user_id' => auth()->id(),
        ]);

        $count = Like::where('post_id', $id)->count();

        return response()->json(['post_id' => $id, 'likes_count'=> $count, 'message' => 'Like added successfully']);
    }
}
