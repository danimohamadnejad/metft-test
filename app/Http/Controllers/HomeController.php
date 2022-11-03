<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Metft\FeedReader\Models\NewsServer;

class HomeController extends Controller
{
    public function index(){
     return NewsServer::create(
       [
        "name"=>"Cointelegraph",
        "home_url"=>"https://cointelegraph.com",
        "feeds_url"=>"https://cointelegraph.com/rss"
       ]
     );     
    }
}
