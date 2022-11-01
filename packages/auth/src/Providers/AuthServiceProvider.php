<?php
namespace Metft\Auth\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AuthServiceProvider extends ServiceProvider{
 public function boot(){
    $this->mergeConfigFrom(__DIR__.'/../../config/auth.php', 'metft-auth');
    $this->publishes([
      __DIR__.'/../../config/auth.php', config_path('metft-auth.php')
    ], 'metft-auth');
    $this->load_routes();
 }
 
 public function register(){
    
 }

 private function load_routes(){
    $config = config('metft-auth');
    Route::group([
      'prefix'=>$config['routes-prefix'],
      'as'=>$config['routes-alias'],
      'namespace'=>"Metft\Auth\Http\Controllers"
    ], function(){
     $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');  
    });
 }
}