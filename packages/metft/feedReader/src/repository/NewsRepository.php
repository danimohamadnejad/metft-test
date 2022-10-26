<?php

namespace Metft\FeedReader\repository;

use Carbon\Carbon;
use Exception;
use Metft\FeedReader\Models\News;
use Illuminate\Support\Str;
use Metft\Translator\repository\TranslateRepository;

class NewsRepository {

    protected $title='';
    protected $linke='';
    protected $title_hash='';
    protected $server_id='';
    protected $category='';
    protected $description='';
    protected $cover_image='';
    protected $news;


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

    public function parseItem(Array $item)
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

    public function updateOrInsert()
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
    }

}