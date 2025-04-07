<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('user');
        
        if ($request->has('trashed') && $request->trashed == 1) {
            $query = $query->onlyTrashed();
            $showingTrashed = true;
        } else {
            $showingTrashed = false;
        }
        
        $posts = $query->latest()->paginate(10);
        
        return view('posts.index', compact('posts', 'showingTrashed'));
    }

    public function create()
    {
        $users = User::all();
        return view('posts.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        Post::create($request->all());

        return redirect()->route('posts.index')
                         ->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $users = User::all();
        return view('posts.edit', compact('post', 'users'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $post->update($request->all());

        return redirect()->route('posts.index')
                         ->with('success', 'Post updated successfully.');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comments.user']);
        return view('posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        if (request()->has('confirm') && request('confirm') === 'yes') {
            $post->delete();
            return redirect()->route('posts.index')
                             ->with('success', 'Post deleted successfully.');
        }
        
        return view('posts.delete-confirm', compact('post'));
    }
    
    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();
        
        return redirect()->route('posts.index', ['trashed' => 1])
                         ->with('success', 'Post restored successfully.');
    }
}
