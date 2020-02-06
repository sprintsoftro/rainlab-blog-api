<?php

namespace Bedard\RainLabBlogApi\Tests;

use App;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;
use PluginTestCase as BasePluginTestCase;
use System\Classes\PluginManager;
use RainLab\Blog\Models\Category;
use RainLab\Blog\Models\Post;

class PluginTestCase extends BasePluginTestCase
{
    /**
     * @var array Plugins to refresh between tests.
     */
    protected $refreshPlugins = [
        'RainLab.Blog',
    ];

    /**
     * Set up function, called before each test.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        App::singleton(Factory::class, function ($app) {
            $faker = $app->make(Generator::class);

            return Factory::construct($faker, plugins_path('bedard/rainlabblogapi/factories'));
        });

        $pluginManager = PluginManager::instance();
        $pluginManager->registerAll(true);
        $pluginManager->bootAll(true);

        Category::truncate();
        Post::truncate();
    }

    /**
     * Tear down function, called after each test.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        $pluginManager = PluginManager::instance();
        $pluginManager->unregisterAll();
    }
}
