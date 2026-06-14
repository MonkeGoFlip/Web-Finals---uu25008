@extends('layout')

@if ($errors->any())
    <div style="background-color: #fee2e2; color: #dc2626; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
        <ul style="margin: 0; padding-left: 1.5rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Create New Post</h2>
    
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" style="width: 100%; padding: 0.5rem; border: 1px solid #d4d4d8; border-radius: 4px;" required></textarea>
        </div>

        <div class="form-group">
            <label for="type">Post Type</label>
            <select id="type" name="type" style="width: 100%; padding: 0.5rem; border: 1px solid #d4d4d8; border-radius: 4px;" required>
                <option value="midi">MIDI Configuration</option>
                <option value="practice">Practice Log</option>
                <option value="composition">Musical Composition</option>
            </select>
        </div>

        <div class="form-group">
            <label for="file">Attach File (Optional)</label>
            <input type="file" id="file" name="file" style="width: 100%; padding: 0.5rem;">
        </div>

        <div class="form-group">
            <label>Tags</label>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                @foreach($tags as $tag)
                    <label style="font-weight: normal;">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"> {{ $tag->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <button type="submit" style="margin-top: 1rem;">Publish Post</button>
    </form>
</div>
@endsection