<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id');
        $postIds = Post::pluck('id');

        if ($userIds->isEmpty() || $postIds->isEmpty()) {
            return;
        }

        foreach (range(1, 30) as $i) {
            Comment::factory()->create([
                'user_id' => $userIds->random(),
                'post_id' => $postIds->random(),
            ]);
        }
    }
}
