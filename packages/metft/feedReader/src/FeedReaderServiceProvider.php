<?php
namespace Metft\FeedReader;

use Illuminate\Support\ServiceProvider;

class FeedReaderServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->mergeConfigFrom(__DIR__.'/config/feedReader.php', "feedReader");
        $this->publishes([
            __DIR__.'/config/feedReader.php' => config_path('feedReader.php'),
        ], "metft.feedReader");
        // $this->loadRoutesFrom(__DIR__.'/routes/api.php');
      /*   $this->loadFactoriesFrom(__DIR__.'/database/factories'); */
    }
    
    
    public function register()
    {

    }
}