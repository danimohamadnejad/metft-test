<?php

namespace Metft\FeedReader\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Metft\Database\Factories\NewsServerFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Metft\FeedReader\Traits\ApplyModelFiltersFromQueryString;
use Metft\FeedReader\Traits\ModelPaginationPerPage;

class NewsServer extends Model
{
    use HasFactory;
    use SoftDeletes;
    use ApplyModelFiltersFromQueryString;
    use ModelPaginationPerPage;
    
    private $filters = [
        'q'=>['method'=>'filter_with_search_term', 'value'=>null],
    ];
    protected $fillable=[
        'name', 'details', 'logo', "home_url", "feeds_url", 'status'
    ];
    protected static $nullable_fields = ['details'];
    protected $table = "news_servers";
    protected static function boot(){
       parent::boot();
       static::creating(function($model){
        foreach(static::$nullable_fields as $field){
            if(is_null($model->$field)){
                $model->$field = "";
            }
        }
       }); 
    }
    protected static function newFactory(){
        return NewsServerFactory::new();
    }
    public function news()
    {
        return $this->hasMany(News::class);
    }
    public function get_searchable_fields(){
        return ['name', 'home_url', 'feeds_url', 'details'];
    }
    public function scopeFilter_with_search_term($query, $value = ''){
        if(!empty($value)){
            $search_value = "%${value}%";
            $searchable_fields = $this->get_searchable_fields(); 
            $query->where(function($query) use($search_value, $searchable_fields){
                foreach($searchable_fields as $field){
                    $query->orWhere($field, "like", $search_value);
                }
            });
        }
        return $query;
    }
    public function scopeActive($query){
        return $query->whereStatus(feed_reader_get_news_server_active_status_value());
    }
}
