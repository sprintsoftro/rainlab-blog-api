<?php

namespace Bedard\RainLabBlogApi\Http\Controllers;

use BackendAuth;
use Bedard\RainLabBlogApi\Classes\ApiController;
use Illuminate\Support\Arr;
use RainLab\Blog\Models\Category;
use RainLab\Blog\Models\Settings;

class CategoriesController extends ApiController
{
    /**
     * List categories.
     *
     * @return array
     */
    public function index()
    {
        $categories = Category::get();

        return $categories;
    }
    /**
     * List categories.
     *
     * @return array
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $arCategory = [
            "id"            => $category->id,
            "name"          => $category->name,
            "slug"          => $category->slug,
            "code"          => $category->code,
            "description"   => $category->description,
            "header_image"  => $category->header_image->getPath(),
            'posts'         => $category->posts,
        ];

        return $arCategory;
    }
}
