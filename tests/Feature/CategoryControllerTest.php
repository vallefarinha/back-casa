<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Category;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CategoryControllerTest extends TestCase
{   
    use WithFaker;
    public function test_create_category()
    {
        $user = User::where('email', 'casalaguia@example.com')->first();
        $this->actingAs($user);

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
        $categoriesCount = Category::count();
        $this->assertCount($categoriesCount, $responseData['categories']);
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
        $user = User::where('email', 'casalaguia@example.com')->first();
        $this->actingAs($user);
        $category = Category::factory()->create();
        $updatedData = [
            'name' => $this->faker->word(),
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
        $user = User::where('email', 'casalaguia@example.com')->first();
        $this->actingAs($user);
        $category = Category::factory()->create();
    
        $response = $this->deleteJson("/api/category/destroy/{$category->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $responseData = $response->json();
        $this->assertEquals('Categoría eliminada correctamente', $responseData['message']);
    }
}
