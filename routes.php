<?php

if (config('bedard.rainlabblogapi::apiEnable')) {
    $prefix = config('bedard.rainlabblogapi::apiPrefix');

    Route::prefix($prefix)->middleware('web')->group(function () {
        // ...
    });
}
