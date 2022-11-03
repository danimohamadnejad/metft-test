<?php

namespace Metft\FeedReader\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Metft\FeedReader\Models\NewsServer;
use Metft\FeedReader\Facades\FeedsReaderFacade;
use Metft\FeedReader\Repository\NewsRepository;
use Metft\FeedReader\Jobs\CreateAndTranslateFeedJob;

class ReadAndProcessServerFeedsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private ?NewsServer $news_server = null;

    public function __construct(NewsServer $news_server)
    {   
        $this->news_server = $news_server;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $reader = FeedsReaderFacade::set_server($this->news_server)->read();
        if($reader->has_loaded_feeds()){
            $reader->traverse_loaded_feeds(function(array $feed){
                CreateAndTranslateFeedJob::dispatch($feed);
            });  
        }
       
    }
    
}
