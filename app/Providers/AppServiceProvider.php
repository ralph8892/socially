<?php

namespace App\Providers;

use App\Models\Post;
use App\Events\TestEventOne;
use App\Policies\PostPolicy;
use App\Listeners\TestListenerOne;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
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
        Event::listen(
            TestEventOne::class,
            TestListenerOne::class,
        );
        
        Gate::policy(Post::class, PostPolicy::class);

        Gate::define('visitAdminPages', function ($user) {
            return $user->isAdmin === 1;
        });

        Paginator::useBootstrapFive();
    }
}
