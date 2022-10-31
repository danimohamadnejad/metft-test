<?php
namespace Metft\FeedReader\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
/* use Metft\FeedReader\Http\Resources\TranslationResource; */
use Metft\FeedReader\Http\Resources\NewsServerResource;
use Aryanhasanzadeh\Translator\App\Http\Resources\TranslateResource;


class FeedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /* $out =  parent::toArray($request); */
        $searchable_fields = $this->get_searchable_fields();
        
        $out = array_merge([
            "__id"=>$this->getKey(),
        ], $this->get_base_fields(), [
            'server'=>NewsServerResource::make($this->whenLoaded('server')),
            'locale_translations'=>TranslateResource::collection($this->whenLoaded('locale_translations')),
        ]);
        foreach($searchable_fields as $field){
            $translation_data = '';
            if($this->relationLoaded('locale_translations')){
             $translation = $this->locale_translations->where('type', $field)->first();
             if($translation){
                $translation_data = $translation->data;
             }
            }
            $out[$field] = $translation_data;  
        }
        return $out;
    }
    private function get_base_fields(){
        $fields = ['title_hash', 'link', 'cover_image_url', 'server_id', 
    'is_positive', 'is_negative', 'favorit_count', 'comment_count', 'created_at', 'updated_at'];
        $out = [];
        foreach($fields as $field){
          $out[$field] = $this->$field;
        }
        return $out;
    }
}
