@extends('layout')

@section('content')
<div class="dashboard-container">
    
    <div class="main-content" id="post-list">
        @include('partials.post_cards', ['posts' => $posts])
    </div>

    <div class="sidebar">
        <h3 style="margin-top: 0;">{{ __('app.filters') }}</h3>
        <div style="display: flex; flex-direction: column; gap: 0.5rem;" id="filters">
            <label><input type="checkbox" class="filter-checkbox" value="midi"> midi</label>
            <label><input type="checkbox" class="filter-checkbox" value="practice"> practice</label>
            <label><input type="checkbox" class="filter-checkbox" value="composition"> composition</label>
        </div>
    </div>

</div>

<script>
    const searchBox = document.getElementById('searchInput');
    const checkboxes = document.querySelectorAll('.filter-checkbox');
    const postList = document.getElementById('post-list');
    async function fetchFilteredPosts() {
        // 1. Get the text from the search bar
        const searchTerm = searchBox.value;

        // 2. See which checkboxes are checked
        const selectedTypes = Array.from(checkboxes)
            .filter(box => box.checked)
            .map(box => box.value);

        // 3. Build the URL query string
        const params = new URLSearchParams();
        if (searchTerm) params.append('search', searchTerm);
        selectedTypes.forEach(type => params.append('types[]', type));

        // 4. Ping Laravel using the native browser Fetch API
        try {
            const response = await fetch(`/search?${params.toString()}`);
            const html = await response.text();
            
            // 5. Update the page without refreshing
            postList.innerHTML = html;
        } catch (error) {
            console.error('Error fetching posts:', error);
        }
    }

    // Attach the function to user actions
    searchBox.addEventListener('keyup', fetchFilteredPosts);
    checkboxes.forEach(box => box.addEventListener('change', fetchFilteredPosts));
</script>
@endsection