@if($posts->isEmpty())
    <p>No posts found matching those filters.</p>
@endif

@foreach($posts as $post)
    <div class="post-card">
        <h3>{{ $post->title }}</h3>
        <p>{{ $post->description }}</p>
        
        <div>
            <span class="tag" style="background: #d4d4d8;">{{ $post->type }}</span>
            @foreach($post->tags as $tag)
                <span class="tag">{{ $tag->name }}</span>
            @endforeach
        </div>

        <a href="{{ route('posts.show', $post->id) }}">
            <button style="margin-top: 1rem;">{{ __('app.view') }}</button>
        </a>
    </div>
@endforeach

@auth
    <div style="text-align: center; margin-top: 2rem;">
        <a href="{{ route('posts.create') }}">
            <button style="padding: 0.75rem 2rem;">{{ __('app.create_post') }}</button>
        </a>
    </div>
@endauth