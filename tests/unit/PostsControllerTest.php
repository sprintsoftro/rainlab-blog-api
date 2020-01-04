<?php

namespace Bedard\RainLabBlogApi\Tests\Unit;

use Bedard\RainLabBlogApi\Tests\PluginTestCase;
use RainLab\Blog\Models\Post;

class PostsControllerTest extends PluginTestCase
{
    //
    // index
    //
    public function test_fetching_posts()
    {
        factory(Post::class, 20)->create();

        $response = $this->get('/api/rainlab/blog/posts?page=2&perPage=5');
        $response->assertStatus(200);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals(2, $data['current_page']);
        $this->assertEquals(4, $data['last_page']);
        $this->assertEquals(6, $data['from']);
        $this->assertEquals(10, $data['to']);
        $this->assertEquals(20, $data['total']);
    }
}
