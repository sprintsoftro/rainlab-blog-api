<?php

namespace Bedard\RainLabBlogApi\Tests\Unit\Classes;

use Bedard\RainLabBlogApi\Classes\ApiController;
use Bedard\RainLabBlogApi\Tests\PluginTestCase;

class ApiControllerTest extends PluginTestCase
{
    public function test_extending_the_api_controller_with_middleware()
    {
        ApiController::extend(function ($controller) {
            $controller->middleware(TestMiddleware::class);
        });

        $response = $this->get('/api/rainlab/blog/posts');

        $this->assertEquals('Hello from the test middleware!', $response->getContent());
    }
}

class TestMiddleware
{
    public function handle($request, $next)
    {
        $response = $next($request);
        $response->setContent('Hello from the test middleware!');

        return $response;
    }
}