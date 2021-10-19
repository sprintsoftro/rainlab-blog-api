<?php

namespace Bedard\RainLabBlogApi\Http\Controllers;

use BackendAuth;
use Bedard\RainLabBlogApi\Classes\ApiController;
use Illuminate\Support\Arr;
use RainLab\Blog\Models\Category;
use RainLab\Blog\Models\Settings;
use System\Classes\PluginManager;

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
            "header_image"  => $category->header_image ? $category->header_image->getPath() : null,
            'posts'         => $category->posts,
            'seo_params'    =>  $this->formatSeoParam($category)
        ];

        return $arCategory;
    }

    protected function formatSeoParam($category){
        
        $arSeoParam = [];
        if (PluginManager::instance()->exists('Lovata.MightySeo')) {
            $arSeoParam = $category->seo_param->toArray();
        
            if(empty($arSeoParam['seo_title'])) {
                $arSeoParam['seo_title'] = $category->name;
            }
            if(empty($arSeoParam['seo_description'])) {
                $arSeoParam['seo_description'] = strip_tags($category->description);
            }
            if(!empty($category->preview_image)) {
                $arSeoParam['image'] = $category->preview_image->getPath();
            } elseif(!empty($category->header_image)) {
                $arSeoParam['image'] = $category->header_image->getPath();
            }
            if(empty($arSeoParam['canonical_url'])) {
                $arSeoParam['canonical_url'] = '/blog-seminee/' . $category->slug;
            }
        }
        return $arSeoParam;
    }
}
