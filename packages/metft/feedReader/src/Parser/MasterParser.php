<?php

namespace Metft\FeedReader\Parser;

use Exception;
use Illuminate\Support\Facades\Http;
use Metft\FeedReader\Models\NewsServer;
use Metft\FeedReader\repository\NewsRepository;
use Metft\Translator\SingleTon\GetTranslator;

class MasterParser {

    protected $SerName="";
    protected $SerUrl="";
    protected $SerId="";
    protected $parsedData=[];
    protected $response='';
    protected $useTranslator=false;


    public function setServer(NewsServer $server)
    {
        $this->SerId=$server->id;
        $this->SerUrl=$server->linke;
        $this->SerName=$server->name;

        return $this;
    }

    public function getSerName() : String
    {
        return $this->SerName;
    }
    
    public function getSerUrl() : String
    {
        return $this->SerUrl;
    }

    public function setTranslator($useTranslator)
    {
        $this->useTranslator=$useTranslator;
        return $this;
    }

    public function render()
    {
        if(empty($this->SerName) || empty($this->SerUrl) || empty($this->SerId)){
            throw new Exception("Server not Set", 1);
        }
        $this->response=Http::get($this->SerUrl);

        $this->parser(json_decode(json_encode(simplexml_load_string($this->response->body(), "SimpleXMLElement", LIBXML_NOCDATA)),TRUE));
    }


    public function getData() : array
    {
        return $this->parsedData;
    }

    public function parser(Array $res)
    {
        $newsRepo=(new NewsRepository())->setServer($this->SerId);
        
        foreach ($res['channel']['item'] as $index => $item) {
            $newsRepo->parseItem($item)->updateOrInsert();
        }
        
        return dd('ok');
    }

}