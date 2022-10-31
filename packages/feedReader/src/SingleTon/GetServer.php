<?php

namespace Metft\FeedReader\SingleTon;

use Metft\FeedReader\Factory\ServerFactory;

class GetServer {

    public static $instance=[];

    public static function getInstance(String $server) {

        if (!array_key_exists($server,GetServer::$instance)){
            GetServer::$instance[$server]=(new ServerFactory())->create($server);
        }

        return GetServer::$instance[$server];
    }
}