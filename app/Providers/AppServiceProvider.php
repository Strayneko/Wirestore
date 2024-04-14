<?php

namespace App\Providers;

use App\Models\Image;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Cache default product image
        if(!Cache::has('default_image')){
            $image = Image::query()->where('id', 1)->where('product_id', null)->first();
            Cache::put('default_image', $image, now()->addDay());
        }
    }
}
