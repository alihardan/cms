<?php

namespace Statamic\Search;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Statamic\Facades\Search;
use Statamic\Search\Searchables\Assets;
use Statamic\Search\Searchables\Collections;
use Statamic\Search\Searchables\Providers;
use Statamic\Search\Searchables\Taxonomies;
use Statamic\Search\Searchables\Users;

class ServiceProvider extends LaravelServiceProvider
{
    public function register()
    {
        $this->app->singleton(IndexManager::class, function ($app) {
            return new IndexManager($app);
        });

        $this->app->singleton(Providers::class, function () {
            return new Providers;
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\Insert::class,
                Commands\Update::class,
            ]);
        }

        Event::subscribe(UpdateItemIndexes::class);

        collect([
            'collection' => Collections::class,
            'taxonomy' => Taxonomies::class,
            'assets' => Assets::class,
            'users' => Users::class,
        ])->each(fn ($provider, $key) => Search::registerSearchableProvider($key, $provider));
    }
}
