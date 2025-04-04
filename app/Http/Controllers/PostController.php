<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['randomPosts']);
    }
    public function randomPosts()
    {
        $posts = Post::with('author')->latest()->paginate(3);
        return view('home', compact('posts'));
    }
    public function index()
    {
        $posts = Post::with('author')->latest()->get();
        return view('posts.index', compact('posts'));
    }
    public function create()
    {
        return view('posts.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
            'post_resource' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,webp|max:10240'
        ]);

        $post = new Post();
        $post->author_id = Auth::id();
        $post->description = $request->description;

        if ($request->hasFile('post_resource')) {
            $path = $request->file('post_resource')->store('posts', 'public');
            $post->post_resource = $path;
        }

        $post->save();

        return redirect()->route('profile')->with('success', 'Post created successfully.');
    }
    public function show($id)
    {
        $post = Post::with('author')->findOrFail($id);
        $comments = $post->comments()->with('user')->latest()->paginate(5);
        return view('posts.show', compact('post', 'comments'));
    }
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if ($post->author_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        return view('posts.edit', compact('post'));
    }
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->author_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'description' => 'required|string|max:1000',
            'post_resource' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,webp|max:10240'
        ]);

        $post->description = $request->description;

        if ($request->hasFile('post_resource')) {
            // Delete old resource if exists
            if ($post->post_resource) {
                Storage::disk('public')->delete($post->post_resource);
            }

            $path = $request->file('post_resource')->store('posts', 'public');
            $post->post_resource = $path;
        }

        $post->save();

        return redirect()->route('profile')->with('success', 'Post updated successfully.');
    }
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->author_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Delete post resource if exists
        if ($post->post_resource) {
            Storage::disk('public')->delete($post->post_resource);
        }

        $post->delete();

        return redirect()->route('profile')->with('success', 'Post deleted successfully.');
    }
    public function toggleLike($id)
    {
        $post = Post::findOrFail($id);
        $user = Auth::user();

        if ($post->isLikedBy($user)) {
            $post->likes()->where('user_id', $user->id)->delete();
            $message = 'Post unliked successfully.';
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $message = 'Post liked successfully.';
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'likes_count' => $post->likes()->count(),
                'is_liked' => $post->isLikedBy($user)
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}



