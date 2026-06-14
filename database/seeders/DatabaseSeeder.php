<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create a Test User
        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@polyphony.local',
            'password' => Hash::make('password123'),
        ]);

        // 2. Create Tags
        $tagMidi = Tag::create(['name' => 'MIDI']);
        $tagPractice = Tag::create(['name' => 'Practice']);
        $tagComposition = Tag::create(['name' => 'Composition']);
        $tagPiano = Tag::create(['name' => 'Roland FP-E50']);
        $tagAzali = Tag::create(['name' => 'AZALI']);

        // 3. Create Posts
        $post1 = Post::create([
            'user_id' => $user->id,
            'title' => 'Tactical Piano Controller Script',
            'description' => 'A custom MIDI-to-gameplay configuration. Maps piano keys to character abilities for high-ELO play.',
            'type' => 'midi',
        ]);
        // Attach tags via the pivot table
        $post1->tags()->attach([$tagMidi->id, $tagPiano->id]);

        $post2 = Post::create([
            'user_id' => $user->id,
            'title' => 'Learning "seven fourth"',
            'description' => 'Daily practice log. Focusing heavily on the complex polyrhythms in the bridge section today.',
            'type' => 'practice',
        ]);
        $post2->tags()->attach([$tagPractice->id, $tagAzali->id]);

        // 4. Create a Comment
        Comment::create([
            'user_id' => $user->id,
            'post_id' => $post1->id,
            'content' => 'The latency on this mapping is surprisingly low!',
        ]);
    }
}