<?php
namespace Metft\FeedReader;
use Illuminate\Support\ServiceProvider;
use Metft\FeedReader\FacdeBindings\FeedProcessor;
use Metft\FeedReader\FacadeBindings\FeedsReader;
use Metft\FeedReader\FeedsXmlParser;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Resources\Json\JsonResource;
use Metft\FeedReader\Models\NewsServer;
use Metft\FeedReader\Http\Requests\NewsServerSaveRequest;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Metft\FeedReader\Http\Middlewares\SetAppLocaleMiddleware;

class FeedReaderServiceProvider extends ServiceProvider {

    public function boot()
    {
        Route::model("news_server", NewsServer::class);
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', "feedReader");
        $this->mergeConfigFrom(__DIR__.'/config/feedReader.php', "feedReader");
        $this->publishes([
            __DIR__.'/config/feedReader.php' => config_path('metft-feedReader.php'),
        ], "metft.feedReader.config");
        $this->register_routes();
      /*   $this->publishes([
            __DIR__.'/database/seeders/NewsServerSeeder.php'=>database_path("seeders/NewsServerSeeder.php")
        ], "metft.feedReader.seeders"); */
        // $this->loadRoutesFrom(__DIR__.'/routes/api.php');
      /*   $this->loadFactoriesFrom(__DIR__.'/database/factories'); */
    }
    
    private function register_routes(){
        $api_routes_path = __DIR__.'/../routes/api.php';
        $config = config("feedReader");
        Route::group(['namespace'=>"Metft\FeedReader\Http\Controllers", 'middleware'=>[
            SubstituteBindings::class,
            SetAppLocaleMiddleware::class,
        ]
       , 'prefix'=>$config['routes-prefix'] , 'as'=>$config['routes-alias']], function() use($api_routes_path){
            $this->loadRoutesFrom($api_routes_path);
        });
    }

    public function register()
    {
        JsonResource::withoutWrapping();
        $this->app->bind(NewsServerSaveRequest::class, function($app){
            $request = $app['request'];
            return new NewsServerSaveRequest($request->news_server);
        });
        $this->app->bind("feed-processor-facade", function($app){
            return new FeedProcessor;
        });
        $this->app->bind("feeds-reader-facade", function($app){
            return new FeedsReader($app->make(FeedsXmlParser::class));
        });
    }
}