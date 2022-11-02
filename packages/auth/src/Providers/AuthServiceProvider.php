<?php
namespace Metft\Auth\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Metft\Auth\AuthGuard as MetftAuthGaurd;
use Metft\LoginMethods\LoginMethod;
use Meft\LoginMethod\LoginWithIdPass;

class AuthServiceProvider extends ServiceProvider{
 public function boot(){
    $this->mergeConfigFrom(__DIR__.'/../../config/auth.php', 'metft-auth');
    $this->publishes([
      __DIR__.'/../../config/auth.php'=>config_path('metft-auth.php')
    ], 'metft.auth.config');
    $this->load_routes();
    $this->create_authentication_guard(); 
 }
 private function create_authentication_guard(){
  Auth::extend("metft", function($app, $name, $config){
    return new MetftAuthGaurd(Auth::createUserProvider($config['provider']), $app->make(LoginMethod::class));
  });
 }  
 public function register(){
  $this->bind_incoming_request_login_method();  
 }
 private function bind_incoming_request_login_method(){
  $config = config("metft-auth");
  $this->app->bind(LoginMethod::class, function($app) use($config){
    $login_methods = $config['login-methods'];
    
  });
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