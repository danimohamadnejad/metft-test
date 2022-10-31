<?php
namespace Metft\Auth\Tests;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Metft\Auth\Providers\AuthServiceProvider;

class TestCase extends BaseTestCase{
 /* use RefreshDatabase;  */
 protected $use_in_memory_database = false;

   protected function setUp() : void{
      parent::setUp();
   }

   protected function getPackageProviders($app){
    return [
      AuthServiceProvider::class,
    ];        
   }

   protected function getEnvironmentSetUp($app){
      $config = $app['config'];
      $config->set("database.default", "test");
      if($this->use_in_memory_database){
         $config->set("database.connections.test", [
          "driver"=>"sqlite", "database"=>":memory:", "prefix"=>"",
         ]); 
      }else{
         $connection_data = [
            "driver"=>"mysql", "database"=>"test", "username"=>"root", "password"=>"", 
            'host'=>'localhost',  
         ];
         $config->set("database.connections.test", $connection_data);
      }
   }
}