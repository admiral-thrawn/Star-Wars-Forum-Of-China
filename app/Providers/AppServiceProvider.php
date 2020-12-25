<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Post;
use Illuminate\Support\ServiceProvider;
use Silber\Bouncer\BouncerFacade as Bouncer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Bouncer::ownedVia(Post::class, 'author_id');

        Bouncer::ownedVia(Article::class, 'author_id');
    }
}
