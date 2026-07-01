<?php

use App\Models\Post;
use App\Models\User;
use function Pest\Laravel\{actingAs, postJson};

test('authenticated user can create a post', function () {
    

    $user = User::factory()->create();

    $data = Post::factory()->make()->toArray(); // Makes a fake post 

    actingAs($user, 'sanctum')->postJson(route('posts.store'), $data)
    ->assertCreated();
    
    $this->assertDatabaseHas('posts', [
        'title' => $data['title'],
        'user_id' => $user->id
    ]);
});
