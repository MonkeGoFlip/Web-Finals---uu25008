<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('tags')->latest()->get();
        return view('welcome', compact('posts'));
    }
    public function search(\Illuminate\Http\Request $request)
    {
        $query = Post::with('tags')->latest();
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('types')) {
            $query->whereIn('type', $request->input('types'));
        }
        $posts = $query->get();
        return view('partials.post_cards', compact('posts'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = \App\Models\Tag::all();
        return view('posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        if (\Illuminate\Support\Facades\Auth::user()->is_blocked) {
            abort(403, 'Your account has been blocked from creating content.');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:midi,practice,composition',
            'file' => 'nullable|file|max:10240', // Max 10MB
            'tags' => 'nullable|array'
        ]);

        $filePath = null;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $filePath = $request->file('file')->store('post_files', 'public');
        }

        $post = Post::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'file_path' => $filePath,
        ]);

        if ($request->filled('tags')) {
            $post->tags()->attach($request->tags);
        }

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['user', 'tags', 'comments.user']);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if ($post->user_id != \Illuminate\Support\Facades\Auth::id() && \Illuminate\Support\Facades\Auth::user()->role != 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $tags = \App\Models\Tag::all();
        return view('posts.edit', compact('post', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        if ($post->user_id != \Illuminate\Support\Facades\Auth::id() && \Illuminate\Support\Facades\Auth::user()->role != 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:midi,practice,composition',
            'file' => 'nullable|file|max:10240',
            'tags' => 'nullable|array'
        ]);
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $filePath = $request->file('file')->store('post_files', 'public');
            $post->file_path = $filePath;
        }
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            // Only update the file_path if a new file was uploaded
            'file_path' => $post->file_path, 
        ]);
        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id != \Illuminate\Support\Facades\Auth::id() && \Illuminate\Support\Facades\Auth::user()->role != 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $post->delete(); 
        return redirect()->route('home');
    }
}
