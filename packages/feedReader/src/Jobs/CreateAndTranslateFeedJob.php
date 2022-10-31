<?php

namespace Metft\FeedReader\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Metft\FeedReader\Repository\NewsRepository;

class CreateAndTranslateFeedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private array $feed_data = [];
    public function __construct(array $feed_data){
        $this->feed_data = $feed_data;
    }
    
    public function handle(NewsRepository $news_repo)
    {
        $news_repo->create_feed($this->feed_data);
    }
    
}
