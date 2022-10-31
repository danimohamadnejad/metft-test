<?php
namespace Metft\FeedReader\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Metft\FeedReader\Models\NewsServer;

class NewsServerSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public $news_server = null;
    public function __construct(NewsServer $server = null){
      $this->news_server = $server;
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
            'name'=>['required', 'max:255', $this->get_field_unique_rule('name')], 
            'home_url'=>['required', 'url', 'max:255', $this->get_field_unique_rule('home_url')],
            'feeds_url'=>['required', 'url', 'max:255',$this->get_field_unique_rule('feeds_url')],
            "status"=>['sometimes', "in:".implode(',', feed_reader_get_news_server_status_values())],
            'details'=>['sometimes', 'nullable'],
           /*  "logo"=>['nullable', 'file', 'mimetypes:'.implode(',', Utils::image_mime_types())], */
        ];
    }
    private function get_field_unique_rule($field){
        $out = "unique:news_servers,${field}";
        if(!is_null($this->news_server)){
            $out.=",{$this->news_server->getKey()}";
        }
        return $out;
    }
}
