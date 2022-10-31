<?php
namespace Metft\FeedReader\FacadeBindings;
use Metft\FeedReader\Models\NewsServer;
use Metft\FeedReader\FeedsXmlParser;

use Illuminate\Support\Facades\Http;
class FeedsReader{
  private ?NewsServer $server = null;
  private ?FeedsXmlParser $parser = null;
  private $feeds;
  private $error = '';

  public function __construct(FeedsXmlParser $parser){
    $this->parser = $parser;
    $this->reset();
  }
  
  private function set_error(string $error){
    $this->error = $error;
    return $this;
  }

  public function get_error(){
    return $this->error;
  }

  public function traverse_loaded_feeds($closure){
   $this->feeds->each(function(array $feed) use($closure){
    call_user_func_array($closure, [$feed]); 
   });
  }

  public function get_loaded_feeds(){
    return $this->feeds;
  }
  public function set_server(NewsServer $server){
   $this->server = $server;
   return $this; 
  }  
  private function reset(){
    $this->feeds = collect();
    $this->set_error('');
    return $this;
  }
  public function read(){
    $this->reset();
    $this->parser->reset();
    $url = $this->server->feeds_url;
    try{
      $response = Http::get($url);
    }catch(\Throwable $th){
      /* could not resolve host */
      $this->set_error($th->getMessage());
      return $this; 
    }
    if($response && $response->successful()){
      $body = $response->body();
      if(!empty($body) && $response->header('Content-Type') == FeedsXmlParser::ACCEPTABLE_CONTENT_TYPE){
        $this->parse_and_store_feeds($body);
      }
    }
    return $this;
  }

  public function has_loaded_feeds(){
    return $this->feeds->count() > 0;
  }
  public function has_error(){
    return !empty($this->get_error());
  }
  private function parse_and_store_feeds(string $xml_string){
   $this->parser->set_xml($xml_string)->append_to_feeds([
    "server_id"=>$this->server->getKey(),
   ])->parse();
   $this->feeds = $this->parser->get_feeds();
   return $this; 
  }

}