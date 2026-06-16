@extends('layout')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <h1 style="margin-top: 0; margin-bottom: 0.5rem;">{{ $post->title }}</h1>
            <p style="color: #71717a; font-size: 0.9rem; margin-top: 0;">
                Posted by <strong>{{ $post->user->name }}</strong> on {{ $post->created_at->format('M d, Y') }}
            </p>
        </div>
        
        <div style="display: flex; gap: 1rem; align-items: center;">
            <span class="tag" style="background: #18181b; color: white; font-size: 1rem;">{{ ucfirst($post->type) }}</span>
            
            @if(Auth::check() && (Auth::id() == $post->user_id || Auth::user()->role === 'admin'))
                 <a href="{{ route('posts.edit', $post->id) }}">
                    <button style="background-color: #f4f4f5; color: #18181b; border: 1px solid #d4d4d8; padding: 0.4rem 0.8rem; font-size: 0.9rem;">Edit Post</button>
                </a>
                <form method="POST" action="{{ route('posts.destroy', $post->id) }}" onsubmit="return confirm('Are you sure you want to delete this post?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background-color: #dc2626; padding: 0.4rem 0.8rem; font-size: 0.9rem;">Delete Post</button>
                </form>
            @endif
        </div>
    </div>

    <div style="margin: 1.5rem 0;">
        @foreach($post->tags as $tag)
            <span class="tag">{{ $tag->name }}</span>
        @endforeach
    </div>

    <hr style="border: 0; border-top: 1px solid #e4e4e7; margin: 1.5rem 0;">

    <div style="font-size: 1.1rem; line-height: 1.6; white-space: pre-wrap;">
        {{ $post->description }}
    </div>

    @if($post->file_path)
        <div style="margin-top: 2rem; padding: 1.5rem; background-color: #f4f4f5; border-radius: 8px; border: 1px dashed #a1a1aa;">
            <h3 style="margin-top: 0;">Attached File</h3>
            <p>This post includes a downloadable file configuration.</p>
            <a href="{{ Storage::url($post->file_path) }}" download>
                <button>Download File</button>
            </a>
        </div>
    @endif

    <hr style="border: 0; border-top: 1px solid #e4e4e7; margin: 2rem 0;">

    <h3 style="margin-top: 0;">Comments ({{ $post->comments->count() }})</h3>
    
    <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
        @forelse($post->comments as $comment)
            <div style="background-color: #f4f4f5; padding: 1rem; border-radius: 6px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                    <div>
                         <strong>{{ $comment->user->name }}</strong>
                        <span style="color: #71717a; font-size: 0.85rem; margin-left: 0.5rem;">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
    
                    @if(Auth::check() && (Auth::id() === $comment->user_id || Auth::user()->role === 'admin'))
                        <form method="POST" action="{{ route('comments.destroy', $comment->id) }}" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background-color: transparent; color: #dc2626; border: none; padding: 0; font-size: 0.85rem; text-decoration: underline; cursor: pointer;">Delete</button>
                        </form>
                    @endif
                </div>
                <p style="margin: 0; line-height: 1.4;">{{ $comment->content }}</p>
            </div>
        @empty
            <p style="color: #71717a; font-style: italic;">No comments yet. Be the first to start the discussion!</p>
        @endforelse
    </div>

    @auth
        <form method="POST" action="{{ route('comments.store', $post->id) }}">
            @csrf
            <div class="form-group">
                <label for="content">Add a Comment</label>
                <textarea id="content" name="content" rows="3" style="width: 100%; padding: 0.5rem; border: 1px solid #d4d4d8; border-radius: 4px;" required></textarea>
            </div>
            <button type="submit">Post Comment</button>
        </form>
    @else
        <p><a href="{{ route('login') }}">Log in</a> to leave a comment.</p>
    @endauth

</div>
@endsection