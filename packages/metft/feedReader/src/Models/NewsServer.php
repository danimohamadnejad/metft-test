<?php

namespace Metft\FeedReader\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Metft\Database\Factories\NewsServerFactory;

class NewsServer extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',/*  'linke', */ 'details', 'logo', "home_url", "feeds_url" 
    ];
    protected $table = "news_servers";
    
    protected static function newFactory(){
        return NewsServerFactory::new();
    }
    public function news()
    {
        return $this->hasMany(News::class);
    }
}
