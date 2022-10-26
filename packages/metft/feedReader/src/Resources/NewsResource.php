<?php

namespace Metft\FeedReader\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Metft\Translator\Resources\TranslateResource;

class NewsResource extends JsonResource
{
    private $loc='en';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        if(isset($request->lang)){
            $this->loc=$request->lang;
        }

        return [
            'slug'=>$this->slug,
            'cover_image'=>$this->cover_image ?? '#',
            'linke'=>$this->linke,
            'is_positive'=>$this->is_positive,
            'is_negative'=>$this->is_negative,
            'favorit_count'=>$this->favorit_count,
            'comment_count'=>$this->comment_count,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'translate'=>TranslateResource::collection($this->translate()->JustLang($this->loc)->get()),
            'server'=>NewsServerResource::make($this->server)
        ];
    }
}
