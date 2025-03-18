<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('author')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
            'post_resource' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4|max:10240'
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('author')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if ($post->author_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->author_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'description' => 'required|string|max:1000',
            'post_resource' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4|max:10240'
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
}
