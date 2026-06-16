@if($posts->isEmpty())
    <p>No posts found matching those filters.</p>
@endif

@foreach($posts as $post)
    <div class="post-card">
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->description }}</p>
        
        <div>
            <span class="tag" style="background: #d4d4d8;">{{ $post->type }}</span>
            @foreach($post->tags as $tag)
                <span class="tag">{{ $tag->name }}</span>
            @endforeach
        </div>

        <a href="{{ route('posts.show', $post->id) }}" style="display: inline-block; margin-top: 1rem; background-color: #18181b; color: #ffffff; padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px;">
            {{ __('app.view') }}
        </a>
    </div>
@endforeach

@auth
    <div style="text-align: center; margin-top: 2rem;">
        <a href="{{ route('posts.create') }}" style="display: inline-block; padding: 0.75rem 2rem; background-color: #18181b; color: #ffffff; text-decoration: none; border-radius: 4px;">
            {{ __('app.create_post') }}
        </a>
    </div>
@endauth