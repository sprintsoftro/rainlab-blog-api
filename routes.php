<?php

if (config('bedard.rainlabblogapi::apiEnable')) {
    $prefix = config('bedard.rainlabblogapi::apiPrefix');

    Route::prefix($prefix)->middleware('web')->group(function () {
        // categories
        Route::get('categories', 'Bedard\RainLabBlogApi\Http\Controllers\CategoriesController@index');
        Route::get('categories/{slug}', 'Bedard\RainLabBlogApi\Http\Controllers\CategoriesController@show');

        // posts
        Route::get('posts', 'Bedard\RainLabBlogApi\Http\Controllers\PostsController@index');
        Route::get('posts/{slug}', 'Bedard\RainLabBlogApi\Http\Controllers\PostsController@show');
    });
}
