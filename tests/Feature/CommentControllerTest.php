<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Comment;
use App\Models\Post;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    public function test_create_comment()
    {

        $comment = Comment::factory()->make()->toArray();

        $response = $this->postJson('/api/create/comment', $comment);

        $response->assertStatus(201);

        $responseData = $response->json();
        $this->assertArrayHasKey('message', $responseData, 'The response does not contain a success message');
        $this->assertEquals('Comentario guardado correctamente', $responseData['message'], 'Erro al crear el comentario');

        $this->assertDatabaseHas('comments', $comment);
    }


}
