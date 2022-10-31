<?php
namespace Metft\FeedReader\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Metft\FeedReader\Models\News;

class NewsSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public $feed = null;
    public function __construct(News $feed = null){
        $this->feed = $feed;
    }
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
          'title'=>['required', 'max:255', $this->get_field_unique_rule("title")],
          'body'=>['required',],
          'link'=>['nullable', 'url', 'max:255'],
          'cover_image_url'=>['nullable', 'url', 'max:255'],
          'server_id'=>['required', 'exists:news_servers,id', ],
        ];
    }
    private function get_field_unique_rule($field){
        return '';
        $out = "unique:news,${field}";
        if(!is_null($this->feed)){
            $out.=",{$this->feed->getKey()}";
        }
        return $out;
    }
}
