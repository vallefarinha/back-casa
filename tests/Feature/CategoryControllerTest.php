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
        $this->assertDatabaseHas('categories', [
            'name' => $category['name'],
        ]);
        $responseData = $response->json();
        $this->assertArrayHasKey('message', $responseData, 'The response does not contain a success message.');
        $this->assertEquals('Categoria guardada correctamente', $responseData['message'], 'La categoria no se guardó correctamente');
    }

    public function test_view_categories()
    {
        $response = $this->getJson('/api/categories');
        $response->assertStatus(200);

        $responseData = $response->json();
        $this->assertArrayHasKey('categories', $responseData, 'The response does not contain categories.');
        $response->assertJsonCount(Category::count());
    }

    public function test_show_category()
    {
        $category = Category::factory()->create();
        $response = $this->getJson("/api/category/{$category->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
            ]
        ]);
    }

    public function test_update_category()
    {
        $category = Category::factory()->create();
        $updatedData = [
            'name' => 'Nueva categoría',
        ];
        $response = $this->putJson("/api/category/update/{$category->id}", $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => $updatedData['name'],
        ]);
        $responseData = $response->json();
        $this->assertEquals('Categoría actualizada correctamente', $responseData['message']);
    }

    public function test_destroy_category()
    {
        $category = Category::factory()->create();
    
        $response = $this->deleteJson("/api/category/destroy/{$category->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $responseData = $response->json();
        $this->assertEquals('Categoría eliminada correctamente', $responseData['message']);
    }
}
