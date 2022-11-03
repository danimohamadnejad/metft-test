<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Metft\FeedReader\Models\NewsServer;

class HomeController extends Controller
{
    public function index(){
     try{
        1/0;
     }catch(\Throwable $th){
        metft_feed_reader_();
     }
    }
}
