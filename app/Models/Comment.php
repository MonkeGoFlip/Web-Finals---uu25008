<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    protected $fillable = ['user_id', 'post_id', 'content'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function post()
    {
       return $this->belongsTo(Post::class);
    }
    use HasFactory;
}
