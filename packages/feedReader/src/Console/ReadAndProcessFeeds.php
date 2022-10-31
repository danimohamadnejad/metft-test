<?php
namespace Metft\FeedReader\Console;
use Metft\FeedReader\Models\NewsServer;
use Metft\FeedReader\Jobs\ReadAndProcessServerFeedsJob;

class ReadAndProcessFeeds {
 public function __invoke(){
   NewsServer::active()->chunk(50, function($servers){
      $servers->each(function($server){
        ReadAndProcessServerFeedsJob::dispatch($server);
      });
   });
 }    
}