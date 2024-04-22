<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Category;

class CategoryModelTest extends TestCase
{
    public function test_category_has_many_posts()
    {
        $category = Category::factory()->create();

        $posts = Post::factory(3)->create(['category_id' => $category->id]);

        $categoryPosts = $category->posts;

        $this->assertCount(3, $categoryPosts);

        foreach ($posts as $post) {
            $this->assertContains($post->id, $categoryPosts->pluck('id'));
        }
    }
    
}
