<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class AdminPostController extends Controller
{
    public function edit(Post $post)
    {
        return view('admin.edit', [
            'post' => $post,
        ]);
    }

    public function updateStatus(Request $request, Post $post)
    {

        $data = [
            'status' => $request->input('status'),
        ];

        $post->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Post has been updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Post has been deleted successfully.');
    }
}
