<?php
namespace Metft\FeedReader\Factories;
use Exception;
use Metft\FeedReader\Models\NewsServer;
use Metft\FeedReader\Parser\MasterParser;

class ServerFactory {
    public function create(String $server) {
        if (!in_array($server,config('feedReader.to-watch-server')))
            throw new Exception("Server Not Found", 1);
        $s=NewsServer::where('name',$server)->firstOrFail();
        return (new MasterParser())->setServer($s);
    }

}