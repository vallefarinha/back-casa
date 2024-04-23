<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;

class PostModelTest extends TestCase
{
    public function test_post_belongs_to_category()
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $post->category);
        $this->assertEquals($category->id, $post->category->id);
    }
    public function test_post_has_many_comments()
    {
        $post = Post::factory()->create();

        $comments = Comment::factory(3)->create(['post_id' => $post->id]);

        $postComments = $post->comments;

        $this->assertCount(3, $postComments);

        foreach ($comments as $comment) {
            $this->assertContains($comment->id, $postComments->pluck('id'));
        }
    }
    
}
