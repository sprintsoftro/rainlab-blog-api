<?php

namespace Bedard\RainLabBlogApi\Http\Controllers;

use BackendAuth;
use Bedard\RainLabBlogApi\Classes\ApiController;
use Illuminate\Support\Arr;
use RainLab\Blog\Models\Post;
use RainLab\Blog\Models\SiblingPost;
// use Bedard\RainLabBlogApi\Models\Post;
use RainLab\Blog\Models\Settings;
use Illuminate\Support\Facades\DB;

class PostsController extends ApiController
{
    /**
     * Determine if the user has edit permissions.
     *
     * @return boolean
     */
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
        $posts = Post::orderBy('published_at','desc')->with('categories', 'user', 'featured_images')->listFrontEnd([
            'page' => input('page', 1),
            'perPage' => input('perPage', 12),
            'category' => input('category')
        ]);

        $posts =  Arr::only($posts->toArray(), [
            'current_page',
            'data',
            'from',
            'last_page',
            'to',
            'total',
        ]);

        //dd($posts);
        return $posts;

    }

    /**
     * Show a post.
     *
     * @return \RainLab\Blog\Models\Post
     */
    public function show($slug)
    {
        $post = new Post;


        $post = $post->isClassExtendedWith('RainLab.Translate.Behaviors.TranslatableModel')
            ? $post->transWhere('slug', $slug)->with('user', 'featured_images')
            : $post->where('slug', $slug)->with('user', 'featured_images');

        if (!$this->checkEditor()) {
            $post = $post->isPublished();
        }

        $post = $post->firstOrFail();

        $next_post=$post->nextPost();

        if ($next_post) {

            $next_post = Post::with('featured_images')->where('id',$next_post->id)->first();

        }

        $post->setAttribute('next_post', $next_post);

        $previous_post = $post->previousPost();

        if ($previous_post) {

            $previous_post = Post::with('featured_images')->where('id',$previous_post->id)->first();

        }

        $post->setAttribute('previous_post', $previous_post);

        return $post;
    }


}
