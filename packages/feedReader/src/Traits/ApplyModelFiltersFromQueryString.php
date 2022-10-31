<?php
namespace Metft\FeedReader\Traits;
trait ApplyModelFiltersFromQueryString{
    
    /* 
     private $filters = [
      'q'=>['method'=>'filter_with_search_term', 'value'=>null]          
     ];
    */
    
    public function scopeFilter($query){
        foreach(request()->query() as $k=>$v){
            if(isset($this->filters[$k]) && !empty($v)){
                $method = $this->filters[$k]['method'];
                call_user_func_array([$query, $method], [$v]);
            }
        }
    }   
}