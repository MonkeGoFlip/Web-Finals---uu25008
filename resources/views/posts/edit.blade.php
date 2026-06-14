@extends('layout')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Edit Post</h2>

    @if ($errors->any())
        <div style="background-color: #fee2e2; color: #dc2626; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" style="width: 100%; padding: 0.5rem; border: 1px solid #d4d4d8; border-radius: 4px;" required>{{ old('description', $post->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="type">Post Type</label>
            <select id="type" name="type" style="width: 100%; padding: 0.5rem; border: 1px solid #d4d4d8; border-radius: 4px;" required>
                <option value="midi" {{ $post->type == 'midi' ? 'selected' : '' }}>MIDI Configuration</option>
                <option value="practice" {{ $post->type == 'practice' ? 'selected' : '' }}>Practice Log</option>
                <option value="composition" {{ $post->type == 'composition' ? 'selected' : '' }}>Musical Composition</option>
            </select>
        </div>

        <div class="form-group">
            <label for="file">Replace File (Optional)</label>
            <input type="file" id="file" name="file" style="width: 100%; padding: 0.5rem;">
            @if($post->file_path)
                <p style="font-size: 0.85rem; color: #71717a; margin-top: 0.25rem;">Current file attached. Uploading a new one will replace it.</p>
            @endif
        </div>

        <div class="form-group">
            <label>Tags</label>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                @foreach($tags as $tag)
                    <label style="font-weight: normal;">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                            {{ $post->tags->contains($tag->id) ? 'checked' : '' }}> 
                        {{ $tag->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 1rem;">
            <button type="submit">Save Changes</button>
            <a href="{{ route('posts.show', $post->id) }}" style="text-decoration: none;">
                <button type="button" class="btn-outline">Cancel</button>
            </a>
        </div>
    </form>
</div>
@endsection