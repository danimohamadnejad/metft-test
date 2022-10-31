<?php
namespace Metft\FeedReader\Facades;
use Illuminate\Support\Facades\Facade;
class FeedsReaderFacade extends Facade{
    protected static function getFacadeAccessor(){
        return "feeds-reader-facade";
    }
}