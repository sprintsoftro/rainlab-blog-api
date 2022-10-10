<?php

namespace Bedard\RainLabBlogApi\Http\Controllers;

use BackendAuth;
use Bedard\RainLabBlogApi\Classes\ApiController;
use Illuminate\Support\Arr;
use RainLab\Blog\Models\Post;
use RainLab\Blog\Models\Settings;
use Initbiz\SeoStorm\Models\Settings as SeoStormSettings;
use System\Models\EventLog;

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
        $posts = Post::orderBy('published_at','desc')
            ->with('categories', 'user', 'featured_images')
            ->listFrontEnd([
                'page' => input('page', 1),
                'perPage' => input('perPage', 12),
                'category' => input('category')
        ]);

        $arPosts =  Arr::only($posts->toArray(), [
            'current_page',
            'data',
            'from',
            'last_page',
            'to',
            'total',
        ]);

        $extension = getImageExtensionByAgent();

        $isDesktop = isDesktop();
        $imageWidth = $isDesktop ? 256 : 400;
        $imageHeight = $isDesktop ? 188 : 300;


        // Change image format to webp for performance
        foreach ($posts as $key => $post) {
            foreach ($post->featured_images as $key1 => $image) {
                $arPosts['data'][$key]['featured_images'][$key1]['path'] = $image->getThumb($imageWidth, $imageHeight, ['mode' => 'fit', 'quality' => 100, 'extension' => $extension]);
            }
            // Only necessary data
            $selectedData = [
                'id',
                'title',
                'slug',
                'featured_images',
                'published',
                'published_at',
                'user'
            ];
            
            if(input('with_categories')) {
                $selectedData[] = 'categories';
            }

            $arPosts['data'][$key] = Arr::only($arPosts['data'][$key], $selectedData);
        }

        return $arPosts;

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
            ? $post->transWhere('slug', $slug)->with('user', 'featured_images', 'header_image', 'seostorm_options')
            : $post->where('slug', $slug)->with('user', 'featured_images', 'header_image', 'seostorm_options');

        if (!$this->checkEditor()) {
            $post = $post->isPublished();
        }
        
        $post = $post->first();

        if(!$post) {
            $userAgent = request()->userAgent();
            $referer = request()->headers->get('referer');
            EventLog::add('!ERROR Pagina Blog Post pe Link-ul: "pefoc.ro/'.$slug.'" -> Blog inexistent sau lipsa redirect /// AGENT:'.$userAgent.' /// REFERER: '.$referer, 'error');
            return ['404'=>true];
        }
        
        $extension = getImageExtensionByAgent();
        
        // Get next Post
        $arNextPost = NULL;
        $nextPost = $post->nextPost();
        if ($nextPost) {
            $featuredImages = $nextPost->featured_images;
            $arNextPost = $nextPost->toArray();
            foreach ($featuredImages as $key => $image) {
                $arNextPost['featured_images'][$key]['path'] = $image->getThumb(500, 200, ['mode' => 'auto', 'quality' => 100, 'extension' => $extension]);
            }
            $arNextPost = Arr::only($arNextPost, [
                'id',
                'featured_images',
                'title',
                'slug'
            ]);
        }

        $post->setAttribute('next_post', $arNextPost);
        

        // Get Previous Post
        $arPrevPost = NULL;
        $previousPost = $post->previousPost();

        if ($previousPost) {
            $featuredImages = $previousPost->featured_images;
            $arPrevPost = $previousPost->toArray();
            foreach ($featuredImages as $key => $image) {
                $arPrevPost['featured_images'][$key]['path'] = $image->getThumb(500, 200, ['mode' => 'auto', 'quality' => 100, 'extension' => $extension]);
            }
            $arPrevPost = Arr::only($arPrevPost, [
                'id',
                'featured_images',
                'title',
                'slug'
            ]);
        }

        $post->setAttribute('previous_post', $arPrevPost);
        
        // Get Seo Data
        if(isset($post->seostorm_options->options)) {

            $meta_options = $post->seostorm_options->options;
            
            if(empty($meta_options['meta_title'])) {
                $meta_options['meta_title'] = $post->title; 
            }

            if(empty($meta_options['og_title'])) {
                $meta_options['og_title'] = $meta_options['meta_title']; 
            }

            if($post->seostorm_options->options['site_name']) {
                $meta_options['meta_title'] = SeoStormSettings::get('site_name') .' - '. $meta_options['meta_title'];
                $meta_options['og_title'] = SeoStormSettings::get('site_name') .' - '. $meta_options['og_title'];
            }
        
            $post->seostorm_options->options = $meta_options;
        }

        // Format images to WEBP
        $arPost = $post->toArray();

        // Format featured_images
        foreach ($post->featured_images as $key => $image) {
            $arPost['featured_images'][$key]['path'] = $image->getThumb(500, 200, ['mode' => 'auto', 'quality' => 100, 'extension' => $extension]);
        }

        // Format header_image
        $arPost['header_image']['path'] = $post->header_image 
            ? $post->header_image->getThumb(0, 0, ['mode' => 'auto', 'quality' => 100, 'extension' => $extension]) 
            : null;

        unset($arPost['content_html']);
        
        return $arPost;
    }


}
