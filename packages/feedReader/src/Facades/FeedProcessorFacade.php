<?php
namespace Metft\FeedReader\Facades;
use Illuminate\Support\Facades\Facade;

class FeedProcessorFacade extends Facade{
    protected static function getFacadeAccessor(){
        return "feed-processor-facade";
    }
}