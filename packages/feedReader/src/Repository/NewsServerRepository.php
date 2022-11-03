<?php
namespace Metft\FeedReader\Repository;
use Metft\FeedReader\Models\NewsServer;
use Illuminate\Database\Eloquent\Builder;

class NewsServerRepository {
    private ?NewsServer $model = null;
    private ?Builder $query = null;

    public function __construct(NewsServer $model){
       $this->model = $model; 
       $this->clear_query();
    }
    public function clear_query(){
       $this->query = $this->model->query();
       return $this;  
    }
    public function create_server(array $data){
        return $this->model->create($data);
    }
    public function find($id){
        return $this->model->find($id);
    }
    public function update_server(NewsServer $server, array $data){
        $res = $server->update($data);
        if($res){
         return $this->find($server->getKey());
        }
        return $res;
    }
    public function chunk($count = 100, $callback){
        $this->model->chunk($count, function($collection) use($callback){
            call_user_func_array($callback, [$collection]);    
        });
    }
    
    public function delete_server(NewsServer $server){
        return $server->delete();
    }
    public function get_query(){
        return $this->query;
    }
    public function filter(){
     $this->query->filter();
     return $this;
    }
    public function paginate(array $appendable_params = []){
      return $this->query->paginate($this->model->get_per_page())->appends($appendable_params);  
    }
    public function has_active_server(){
        return $this->model->active()->count() > 0;
    }
}