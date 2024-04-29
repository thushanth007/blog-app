<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PostController extends Controller
{
    public function add()
    {
        return view('post.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $imagePath = $request->file('image')->store('images', 'public');
    
        $post = Post::create([
            'content' => $request->input('content'),
            'image' => $imagePath,
            'created_by' => Auth::user()->id
        ]);
    
        return redirect()->route('dashboard')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        return view('post.edit', [
            'post' => $post,
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $data = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ];
    
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($post->image);
    
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath;
        }
    
        $post->update($data);
    
        return redirect()->route('dashboard')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Post deleted successfully.');
    }
}
