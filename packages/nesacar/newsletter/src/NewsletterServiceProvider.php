<?php

namespace nesacar\newsletter;

use Illuminate\Support\ServiceProvider;

class NewsletterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //loading the routes files
        //require __DIR__ . '/routes/web.php';

        //define route to be published
        $this->publishes([
            __DIR__ . '/routes/web.php' => base_path('/routes/newsletter.php')
        ]);

        //define the path for the view files
        $this->loadViewsFrom(__DIR__ .'/../views', 'newsletter');

        //define the migrations which going to be published.
        $this->publishes([
            __DIR__ . '/migrations/' => database_path('migrations'),
        ], 'migrations');

        //define the models which going to be published.
        $this->publishes([
            __DIR__ . '/Banner.php' => base_path('app/Banner.php'),
            __DIR__ . '/BannerTranslation.php' => base_path('app/BannerTranslation.php'),
            __DIR__ . '/Click.php' => base_path('app/Click.php'),
            __DIR__ . '/Newsletter.php' => base_path('app/Newsletter.php'),
            __DIR__ . '/Statistic.php' => base_path('app/Statistic.php'),
            __DIR__ . '/Subscriber.php' => base_path('app/Subscriber.php'),
        ], 'models');

        //define the controllers which going to be published.
        $this->publishes([
            __DIR__ . '/Http/Controllers/' => base_path('app/Http/Controllers'),
        ], 'controllers');

        //define the requests which going to be published.
        $this->publishes([
            __DIR__ . '/Http/Requests/' => base_path('app/Http/Requests'),
        ], 'requests');

        //define the views which going to be published.
        $this->publishes([
            __DIR__ . '/../views/' => base_path('resources/views'),
        ], 'admin');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('newsletter', function($app){
            return new Newsletter;
        });
    }
}
