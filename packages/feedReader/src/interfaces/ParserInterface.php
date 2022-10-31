<?php

namespace Metft\FeedReader\interfaces;

interface ParserInterface {

    public function getSerName() : String;
    public function getSerUrl() : String ;

    public function render() ;
    public function getData() : Array;

}