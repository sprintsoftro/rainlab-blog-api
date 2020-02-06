<?php

if (config('bedard.rainlabblogapi::apiEnable')) {
    $prefix = config('bedard.rainlabblogapi::apiPrefix');

    Route::prefix($prefix)->middleware('web')->group(function () {
        Route::get('categories', 'Bedard\RainLabBlogApi\Http\Controllers\CategoriesController@index');
        Route::get('posts', 'Bedard\RainLabBlogApi\Http\Controllers\PostsController@index');
    });
}
