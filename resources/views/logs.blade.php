@extends('layout')

@section('content')
<div class="card" style="max-width: 1000px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h1 style="margin: 0;">System Audit Logs</h1>
        <span class="tag" style="background: #18181b; color: white;">Admin View</span>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #e4e4e7; background-color: #fcfcfc;">
                    <th style="padding: 1rem 0.5rem;">Timestamp</th>
                    <th style="padding: 1rem 0.5rem;">User</th>
                    <th style="padding: 1rem 0.5rem;">Action</th>
                    <th style="padding: 1rem 0.5rem;">Model</th>
                    <th style="padding: 1rem 0.5rem;">Changes (JSON)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr style="border-bottom: 1px solid #e4e4e7;">
                        <td style="padding: 1rem 0.5rem; color: #71717a; font-size: 0.9rem;">
                            {{ $log->created_at->format('Y-m-d H:i:s') }}
                        </td>
                        <td style="padding: 1rem 0.5rem; font-weight: bold;">
                            {{ $log->user->name ?? 'System' }}
                        </td>
                        <td style="padding: 1rem 0.5rem;">
                            @if($log->action === 'created')
                                <span style="color: #16a34a; font-weight: bold;">Created</span>
                            @elseif($log->action === 'deleted')
                                <span style="color: #dc2626; font-weight: bold;">Deleted</span>
                            @else
                                <span style="color: #ca8a04; font-weight: bold;">{{ ucfirst($log->action) }}</span>
                            @endif
                        </td>
                        <td style="padding: 1rem 0.5rem; color: #71717a; font-size: 0.9rem;">
                            {{ class_basename($log->model_type) }} #{{ $log->model_id }}
                        </td>
                        <td style="padding: 1rem 0.5rem;">
                            <details>
                                <summary style="cursor: pointer; color: #3b82f6; font-size: 0.9rem;">View Data</summary>
                                <pre style="background: #f4f4f5; padding: 0.5rem; border-radius: 4px; font-size: 0.8rem; margin-top: 0.5rem; overflow-x: auto;">{{ json_encode($log->changes, JSON_PRETTY_PRINT) }}</pre>
                            </details>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 2rem; text-align: center; color: #71717a;">No audit logs recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection