<?php
namespace Metft\FeedReader\Http\Controllers;
use Metft\FeedReader\Http\Controllers\ApiController;
use Metft\FeedReader\Http\Requests\NewsServerSaveRequest;
use Metft\FeedReader\Repository\NewsServerRepository;
use Metft\FeedReader\Http\Resources\NewsServerResource;
use Metft\FeedReader\Models\NewsServer;
use Illuminate\Http\Request;

class NewsServerController extends ApiController{
    private ?NewsServerRepository $ns_repo = null;

    public function __construct(NewsServerRepository $ns_repo){
        $this->ns_repo = $ns_repo;
    }
    public function index(){
        return NewsServerResource::collection(
            $this->ns_repo->filter()->paginate(),
        );
    }   

    public function update(NewsServerSaveRequest $req, NewsServer $news_server){
      $res = $this->ns_repo->update_server($news_server, $req->validated());
      if($res){
       return $this->successResponse(['news_server'=>$res], "News server updated successfuly");
      }
      return $this->errorResponse([], 500, 'Faild to update news server');
    }
    
    
    public function store(NewsServerSaveRequest $req){
     $res = $this->ns_repo->create_server($req->validated());  
     if(!is_null($res)){
      return $this->successResponse(['news_server'=>NewsServerResource::make($res),], 
      'News server successfuly created.');
     }
     return $this->errorResponse([], 500, "Failed to create news server");
    }


    public function destroy(Request $req, NewsServer $news_server){
        if($this->ns_repo->delete_server($news_server)){
            return $this->successResponse([], "News server deleted successfuly");
        }
        return $this->errorResponse([], 500, "Failed to delete news server");
    }
    
    public function apply_filters_from_query_string(){

    }

    /* 
     $repo->search();
    */
}