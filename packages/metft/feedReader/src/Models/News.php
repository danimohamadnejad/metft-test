<?php

namespace Metft\FeedReader\Models;

use App\Utility\Traits\DateConvertor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Metft\Translator\Traits\HasTranslat;

class News extends Model
{
    use HasFactory;
    use DateConvertor;
    use HasTranslat;

    protected $fillable=[
        'slug',
        'server_id',
        'cover_image',
        'linke',
        'title_hash',
        'is_positive',
        'is_negative',
        'favorit_count',
        'comment_count',
    ];


    protected $garded=[
        'is_positive',
        'is_negative',
        'favorit_count',
        'comment_count',
    ];


    public function server()
    {
        return $this->belongsTo(NewsServer::class);
    }
}
