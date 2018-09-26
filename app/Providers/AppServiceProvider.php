<?php

namespace App\Providers;

use App\Thematic;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if ('admin', function () {
            return in_array(auth()->id(), config('app.admin_users'));
        });


        // Setting feed routes for call for projects by thematic
        if (!$this->app->runningInConsole()) {
            $thematics = Thematic::primary()->get();

            foreach ($thematics as $thematic) {
                $feedsThematic = [
                    'items' => ['App\CallForProjects@getFeedItemsByThematic', $thematic->id],
                    'url' => '/feed/thematic/' . $thematic->id,
                    'title' => 'Les ' . config('feed.itemsPerFeed') . ' derniers dispositifs sur la thématique : ' . $thematic->name,
                ];

                config(['feed.feeds.thematic_' . $thematic->id => $feedsThematic]);
            }
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
