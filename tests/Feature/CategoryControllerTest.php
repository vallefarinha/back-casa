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

    public function test_list_categories()
    {
        $categories = Category::factory()->count(5)->create();

        $response = $this->getJson('/api/categories');
        $response->assertStatus(200);

        $responseData = $response->json();
        $this->assertArrayHasKey('categories', $responseData, 'The response does not contain categories.');

        $retrievedCategories = $responseData['categories'];
        $this->assertCount(5, $retrievedCategories, 'The response does not contain the expected number of categories.');
    }

    }