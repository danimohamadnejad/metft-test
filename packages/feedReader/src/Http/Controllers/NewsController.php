<?php
namespace Metft\FeedReader\Http\Controllers;
use Metft\FeedReader\Http\Controllers\ApiController;
use Metft\FeedReader\Http\Requests\NewsSaveRequest;
use Metft\FeedReader\Repository\NewsRepository;
use Metft\FeedReader\Repository\NewsServerRepository;
use Metft\FeedReader\Http\Resources\FeedResource;
use Illuminate\Http\Request;
use Metft\FeedReader\Console\ReadAndProcessFeeds;

class NewsController extends ApiController{
    private ?NewsRepository $news_repo = null;
    private ?NewsServerRepository $news_server_repo = null;

    public function __construct(NewsRepository $news_repo, NewsServerRepository $news_server_repo){
        $this->news_repo = $news_repo;
        $this->news_server_repo = $news_server_repo;
    }
    public function index(Request $req){
        return FeedResource::collection(
         $this->news_repo->with(['server', 'locale_translations'])->filter()->paginate($req->query())
        );   
    }
    public function store(Request $req, ReadAndProcessFeeds $read_and_process_feeds){
        if($this->news_server_repo->has_active_server()){
          $read_and_process_feeds->__invoke();
          return $this->successResponse([], "We retrieving and processing news...");
        }
        return $this->errorResponse([], 202, "No active news server found.");
    }
}