<?php
namespace Metft\FeedReader\repository;
use Carbon\Carbon;
use Exception;
use Metft\FeedReader\Models\News;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Aryanhasanzadeh\Translator\App\Models\Repository\TranslateRepository;
use Illuminate\Database\Eloquent\Builder;

class NewsRepository {

    protected $title='';
    protected $linke='';
    protected $title_hash='';
    protected $server_id='';
    protected $category='';
    protected $description='';
    protected $cover_image='';
    protected $news;
    private ?News $model = null;
    private ?TranslateRepository $tr_repo = null;
    private ?Builder $query = null;

    private $error = '';

    public function __construct(News $model, TranslateRepository $tr_repo){
        $this->model = $model;
        $this->tr_repo =$tr_repo;
        $this->set_error('');
        $this->clear_query();
    }
    
    public function find($key){
       return $this->query->find($key); 
    }

    public function filter(){
        $this->query->filter();
        return $this;
    }
    public function with($rels = []){
        $this->query->with($rels);
        return $this;
    }
    public function clear_query(){
        $this->query = $this->model->query();
        return $this;  
    }
    public function get_query(){
        return $this->query;
    }
    public function paginate(array $appendable_params = []){
        return $this->query->paginate($this->model->get_per_page())->appends($appendable_params);  
    }
    private function managehash()
    {
        if(!in_array(config('feedReader.hash-method'),hash_algos())) {
            throw new Exception("Active Hash Method Not valid", 1);
        }

        return  Hash(config('feedReader.hash-method'),$this->title) ;
    }

    public function setServer(int $server_id)
    {
        $this->server_id=$server_id;
        return $this;
    }

   /*  public function parseItem(Array $item)
    {
        if(array_diff(config('feedReader.fillables'),array_keys($item)) != []){
            throw new Exception("parser Fildes Not Set", 1);
        }

        if(is_array(config('feedReader.optional_fillables'))){
            foreach (config('feedReader.optional_fillables') as $value) {
                if(isset($this->$value,$item[$value])){
                    $this->$value=$item[$value];
                }
            }
        }

        if (in_array('category',config('feedReader.optional_fillables')) && isset($item['category'])) {
            if (is_array($item['category'])) {
                $item['category']=implode(',',$item['category']);
            }
            $this->category=Strip_tags($item['category']);
        }

        $this->title=Strip_tags($item['title']);
        $this->linke=$item['link'];
        $this->title_hash=$this->managehash();
        $this->description=Strip_tags($item['description']);

        return $this;
    }
 */
    private function set_error(string $error){
        $this->error = $error;
        return $this;
    }
    public function get_error(){
        return $this->error;
    }
    public function create_feed(array $feed_data){
        DB::beginTransaction();
        $feed = null;
        try{
         $feed = $this->model->create($feed_data);
         if(is_null($feed)){
            throw new \Exception('feed could not be created. Server_id: '.$feed_data['server_id']);
         }
         $res = $this->translate_feed($feed);
        }catch(\Throwable $th){
            $this->set_error($th->getMessage());
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
    }
    /* translate relation should have been loaded if feed is to be updated */
    public function update_feed(News $feed, array $data){

    }
    public function translate_feed(News $feed){
           $feed->translate()->delete();
           $translatable_fields = $feed->get_translatable_fields();
           $this->tr_repo->setSource('en');
           foreach($translatable_fields as $field){   
            try{
             $this->tr_repo->setType($field)->setData($feed->$field)->setTranslator(true)->
             setParent($feed)->manageUpdateOrInsert(); 
            }catch(\Throwable $th){
                echo $th->getMessage();
            }
           }
                /* $res = $this->tr_repo->setType($translatable_field)->setData($feed->$translatable_field)
                ->setParent($feed)->setTranslator(true)->manageUpdateOrInsert(); */
           return $this;
    }
  /*   public function updateOrInsert()
    {
        $this->news=News::updateOrCreate(
            [    
                'cover_image'=>!empty($this->cover_image) ? $this->cover_image : null,
                'slug'=> Str::slug($this->title,config('feedReader.slug-separator')),
                'server_id'=>$this->server_id,
                'linke'=>$this->linke,
                'title_hash'=>$this->title_hash,
            ],
            ['cover_image'],
        );

        if ($this->news == null &&  !$this->news instanceof News) {
            throw new Exception("News Model Not Set", 1);
        }

        if (
            $this->news->created_at == $this->news->updated_at && 
            $this->news->updated_at == Carbon::now()->format("Y-m-d H:i:s")
            ) {
            $tlr=new TranslateRepository();
            $tlr->setType(array_search('title',config('translator.types')))->setData($this->title)->setParent($this->news)->setTranslator(config('translator.user-translator'))->manageUpdateOrInsert();
            $tlr->setType(array_search('body',config('translator.types')))->setData($this->description)->setParent($this->news)->setTranslator(config('translator.user-translator'))->manageUpdateOrInsert();
        }


        return $this->news;
    } */

   

}