<?php

namespace Metft\FeedReader\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsServerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            '_id'=>$this->id,
            'name'=>$this->name,
            'link'=>substr($this->linke,0, strrpos($this->linke, '/') ),
        ];
    }
}
