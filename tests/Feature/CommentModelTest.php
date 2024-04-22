<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;

class CommentModelTest extends TestCase
{
    public function test_comment_belongs_to_post()
    {
       
        $post = Post::factory()->create();

        $comment = Comment::factory()->create(['post_id' => $post->id]);
        $commentPost = $comment->post;

        $this->assertEquals($post->id, $commentPost->id);
    }
}