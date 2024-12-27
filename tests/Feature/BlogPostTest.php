<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogPostTest extends TestCase
{
   public function blog_post(): void
   {
       $response = $this->postJson('/blog/add',[
           'title' => 'test title',
           'content' => 'test content',
       ]);
       $response->dump();
       $response->assertStatus(200);
       $response->assertJson([
           'message' => 'Blog added successfully',
       ]);

   }
}
