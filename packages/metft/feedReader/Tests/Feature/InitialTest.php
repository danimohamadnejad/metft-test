<?php
namespace Metft\FeedReader\Tests\Feature;
use Metft\FeedReader\Tests\TestCase;
use Metft\FeedReader\Models\NewsServer;

class InitialTest extends TestCase{
 /** @test */
 public function make_first_test(){
    NewsServer::factory()->create_servers_from_config();
 } 
}