<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class PostObserver
{
    private function log(Post $post, string $action)
    {
        // Only log if a user is actually logged in
        if (Auth::check()) {
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model_type' => Post::class,
                'model_id' => $post->id,
                'changes' => $action === 'updated' ? $post->getChanges() : $post->toArray(),
            ]);
        }
    }

    public function created(Post $post): void
    {
        $this->log($post, 'created');
    }

    public function updated(Post $post): void
    {
        $this->log($post, 'updated');
    }

    public function deleted(Post $post): void
    {
        $this->log($post, 'deleted');
    }
}