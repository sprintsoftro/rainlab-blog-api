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
}
