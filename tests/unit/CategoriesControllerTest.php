<?php

namespace Bedard\RainLabBlogApi\Tests\Unit;

use Bedard\RainLabBlogApi\Tests\PluginTestCase;
use RainLab\Blog\Models\Category;

class CategoriesControllerTest extends PluginTestCase
{
    //
    // index
    //
    public function test_fetching_categories()
    {
        $category = factory(Category::class)->create();
        $response = $this->get('/api/rainlab/blog/categories');
        $response->assertStatus(200);

        $data = json_decode($response->getContent());
        $this->assertEquals(1, count($data));
        $this->assertEquals($category->id, $data[0]->id);
    }
}
