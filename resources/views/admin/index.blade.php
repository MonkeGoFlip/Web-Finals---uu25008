@extends('layout')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <h2>User Management (Admin)</h2>

    <table style="width: 100%; border-collapse: collapse; text-align: left; margin-top: 1rem;">
        <thead>
            <tr style="border-bottom: 2px solid #e4e4e7;">
                <th style="padding: 1rem 0.5rem;">Name</th>
                <th style="padding: 1rem 0.5rem;">Email</th>
                <th style="padding: 1rem 0.5rem;">Role</th>
                <th style="padding: 1rem 0.5rem;">Status</th>
                <th style="padding: 1rem 0.5rem;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr style="border-bottom: 1px solid #e4e4e7;">
                    <td style="padding: 1rem 0.5rem;">{{ $user->name }}</td>
                    <td style="padding: 1rem 0.5rem;">{{ $user->email }}</td>
                    <td style="padding: 1rem 0.5rem;">
                        <span class="tag" style="background: {{ $user->role === 'admin' ? '#3b82f6' : '#71717a' }}; color: white;">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td style="padding: 1rem 0.5rem;">
                        @if($user->is_blocked)
                            <span style="color: #dc2626; font-weight: bold;">Blocked</span>
                        @else
                            <span style="color: #16a34a; font-weight: bold;">Active</span>
                        @endif
                    </td>
                    <td style="padding: 1rem 0.5rem;">
                        @if($user->id !== Auth::id())
                            <form method="POST" action="{{ route('admin.toggleBlock', $user->id) }}">
                                @csrf
                                <button type="submit" style="padding: 0.3rem 0.6rem; font-size: 0.8rem; background-color: {{ $user->is_blocked ? '#16a34a' : '#dc2626' }};">
                                    {{ $user->is_blocked ? 'Unblock' : 'Block User' }}
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection