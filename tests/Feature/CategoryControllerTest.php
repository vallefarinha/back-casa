<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Category;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
     public function test_create_category()
    {
    $category = Category::factory()->make()->toArray();

    $response = $this->postJson('/api/create/category', $category);

    $response->assertStatus(201);
        $responseData = $response->json(); 
        $this->assertArrayHasKey('message', $responseData, 'The response does not contain a success message.');
        $this->assertEquals('Categoria guardada correctamente', $responseData['message'], 'La categoria no se guardó correctamente');
    }
}