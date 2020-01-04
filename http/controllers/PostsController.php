<?php

namespace Bedard\RainLabBlogApi\Http\Controllers;

use BackendAuth;
use Bedard\RainLabBlogApi\Classes\ApiController;
use Illuminate\Support\Arr;
use RainLab\Blog\Models\Post;
use RainLab\Blog\Models\Settings;

class PostsController extends ApiController
{
    protected function checkEditor()
    {
        $backendUser = BackendAuth::getUser();

        return $backendUser
            && $backendUser->hasAccess('rainlab.blog.access_posts')
            && Settings::get('show_all_posts', true);
    }

    /**
     * List posts.
     *
     * @return array
     */
    public function index()
    {
        $posts = Post::with('categories')->listFrontEnd([
            'page' => input('page', 1),
            'perPage' => input('perPage', 10),
            'published'=> !$this->checkEditor(),
        ]);

        return $posts;

        return Arr::only($posts->toArray(), [
            'current_page',
            'data',
            'from',
            'last_page',
            'to',
            'total',
        ]);
    }
}
