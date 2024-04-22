<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;


class PostControllerTest extends TestCase
{
    use WithFaker;
    public function test_create_post()
    {
        $user = User::where('email', 'casalaguia@example.com')->first();
        $this->actingAs($user);


        Storage::fake('public');


        $image = UploadedFile::fake()->image('test_image.jpg');


        $postData = [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'category_id' => 1,
            'author' => $this->faker->name,
            'image' => $image,
        ];

        $response = $this->postJson('/api/create/post', $postData);

        $response->assertStatus(201);


        $response->assertJson([
            'message' => 'Post creado',
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => $postData['title'],
            'content' => $postData['content'],
            'category_id' => $postData['category_id'],
            'author' => $postData['author'],
            'image' => $image->getClientOriginalName(),
        ]);
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
        $user = User::where('email', 'casalaguia@example.com')->first();
        $this->actingAs($user);
    
        $post = Post::factory()->create();
    
        Storage::fake('public');
    
        $newImage = UploadedFile::fake()->image('new_test_image.jpg');
    
        $updatedData = [
            'title' => 'Nuevo título',
            'content' => $post->content,
            'category_id' => $post->category_id,
            'author' => $post->author,
            'image' => $newImage,
        ];
    
        $response = $this->postJson("/api/post/{$post->id}/update", $updatedData);
    
        $response->assertStatus(200);
    
        $response->assertJson([
            'message' => 'Post actualizado correctamente',
        ]);
       
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => $updatedData['title'],
            'image' =>  $updatedData['image']->getClientOriginalName(),
        ]);
        
        $this->assertTrue(File::exists(public_path('images/' . $updatedData['image']->getClientOriginalName())), 'La imagen no se encuentra en la ubicación esperada: ' . public_path('images/' . $updatedData['image']->getClientOriginalName()));
    }
    
    public function test_delete_post()
    {
        $user = User::where('email', 'casalaguia@example.com')->first();
        $this->actingAs($user);

        $post = Post::factory()->create([
            'image' => 'test_image.jpg',
        ]);

        $response = $this->deleteJson("/api/post/{$post->id}/delete");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);

        $imagePath = public_path('images/') . $post->image;
        $this->assertFalse(file_exists($imagePath), "El archivo $imagePath existe, pero se esperaba que no existiera.");
    }
}
