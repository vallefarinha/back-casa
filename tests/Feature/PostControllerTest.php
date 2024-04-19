<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Post;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    public function test_create_post()
    {

        $post = Post::factory()->make()->toArray();

        $response = $this->postJson('/api/create/post', $post);

        $response->assertStatus(201);

        $responseData = $response->json();
        $this->assertArrayHasKey('message', $responseData, 'The response does not contain a success message');
        $this->assertEquals('Post creado', $responseData['message'], 'Erro al criar el post');

        $this->assertDatabaseHas('posts', $post);
    }

    public function test_view_posts()
    {
        $response = $this->getJson('/api/posts');
        $response->assertStatus(200);

        $responseData = $response->json();
        $this->assertArrayHasKey('posts', $responseData, 'The response does not contain posts.');

        $retrievedPosts = $responseData['posts'];

        $this->assertNotEmpty($retrievedPosts, 'The response does not contain any posts.');
    }

    public function test_view_post()
    {
        $post = Post::factory()->create();

        $response = $this->getJson("/api/post/{$post->id}");

        $response->assertStatus(200);

        $response->assertJson([
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'category_id' => $post->category_id,
                'author' => $post->author,
                'image' => $post->image,
            ]
        ]);
    }

    public function test_update_post()
    {
        $post = Post::factory()->create();
        error_log("ID do post antes da atualização: " . $post->id);

        $updatedData = [
            'title' => 'Nuevo título',
            'content' => $post->content,
            'category_id' => $post->category_id,
            'author' => $post->author,
            'image' => $post->image,
        ];

        $response = $this->putJson("/api/post/{$post->id}/update", $updatedData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => $updatedData['title'],
        ]);

        $responseData = $response->json();
        $this->assertEquals('Post actualizado correctamente', $responseData['message']);
    }

    public function test_delete_post()
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/post/{$post->id}/delete");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        $responseData = $response->json();
        $this->assertEquals('Post eliminado correctamente', $responseData['message']);
    }

}
