<?php
namespace Metft\FeedReader\Http\Controllers;
use Metft\FeedReader\Http\Controllers\ApiController;
use Metft\FeedReader\Http\Requests\NewsSaveRequest;
use Metft\FeedReader\Repository\NewsRepository;
use Metft\FeedReader\Http\Resources\FeedResource;
use Illuminate\Http\Request;

class NewsController extends ApiController{
    private ?NewsRepository $news_repo = null;
    public function __construct(NewsRepository $news_repo){
        $this->news_repo = $news_repo;
    }
    public function index(Request $req){
        return FeedResource::collection(
         $this->news_repo->with(['server', 'locale_translations'])->filter()->paginate($req->query())
        );   
    }
    public function store(NewsSaveRequest $req){
     $res = $this->news_repo->create_feed($req->validated());
     return $res;
    }
}