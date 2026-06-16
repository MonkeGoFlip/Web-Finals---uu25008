<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        if (Auth::user()->is_blocked) {
            abort(403, 'Your account has been blocked from creating content.');
        }
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);
        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
        ]);
        return back();
    }
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $comment->delete();
        return back();
    }
}