<?php
namespace Metft\FeedReader\Models;
/* use App\Utility\Traits\DateConvertor; */
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Aryanhasanzadeh\Translator\App\Http\Traits\HasTranslat;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Metft\FeedReader\Traits\ModelPaginationPerPage;
use Metft\FeedReader\Traits\ApplyModelFiltersFromQueryString;

class News extends Model
{
    use HasFactory;
  /*   use DateConvertor; */
    use HasTranslat;
    use SoftDeletes;
    use ModelPaginationPerPage;
    use ApplyModelFiltersFromQueryString;
    
    protected $filters = [
        'q'=>['method'=>"filter_with_search_term", 'value'=>null],
    ];

    protected $fillable=[
        "title",
        'slug',
        "body",
        'server_id',
        "cover_image_url",
        'cover_image',
        'link',
        'title_hash',
        'is_positive',
        'is_negative',
        'favorit_count',
        'comment_count',
    ];


    protected $guarded=[
        'is_positive',
        'is_negative',
        'favorit_count',
        'comment_count',
    ];


    public function server()
    {
        return $this->belongsTo(NewsServer::class);
    }

    public function locale_translations(){
        return $this->translate()->justLang(app()->getLocale());
    }

    protected static function boot(){
        parent::boot();
        static::creating(function($model){
            $model->set_model_attributes_on_boot($model);
        });
        static::updating(function($model){
            $model->set_model_attributes_on_boot($model);
        });
    }
    
    private function set_model_attributes_on_boot($model){
        $model->title = strtolower($model->title);
        $model->slug = Str::slug($model->title);
        $model->title_hash = hash("sha1", $model->title);
    }
    public function get_searchable_fields(){
        return ['title', 'body'];
    }
    public function get_translatable_fields(){
        return [
            'title', 'body', 'slug',
        ];
    }
    
  /*   public function scopeFilter_with_search_term($query, $value = ''){
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
    } */
    public function scopeFilter_with_search_term($query, $value = ''){
        if(!empty($value)){
          $search_value = "%${value}%";
          $searchable_fields = $this->get_searchable_fields();
          $query->whereHas('translate', function($tr_query) use($search_value, $searchable_fields){
            $tr_query->where(function($query) use($search_value, $searchable_fields){
                foreach($searchable_fields as $field){
                    $query->orWhere(function($query) use($field, $search_value){
                     $query->where('type', $field)->where('data', 'like', $search_value); 
                    });
                }
            })->justLang(app()->getLocale());
          });  
        }
        return $query;
    }
}
