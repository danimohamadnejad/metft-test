<?php
namespace Metft\FeedReader;
use Illuminate\Support\Str;

class FeedsXmlParser{
  public const ACCEPTABLE_CONTENT_TYPE = "application/xml";
  private $xml_tree = null;
  private $feeds;
  private array $feeds_extra_data = [];

  public function __construct(){
    $this->reset();
  }

  public function reset(){
   $this->xml_tree = null;
   $this->feeds = collect();
   $this->feeds_extra_data = [];
   return $this;
  }

  public function set_xml(string $xml_string){
    if(empty($xml_string)){
        return $this;
    }
    $this->xml_tree = simplexml_load_string($xml_string);
    return $this;
  }
  
  public function parse(){
    if(!empty($this->xml_tree)){
     $this->extract_feeds();
    }
  }
  public function get_feeds(){
    return $this->feeds;
  }
  
  public function append_to_feeds(array $data){
    $this->feeds_extra_data = $data;
    return $this;
  }

  private function extract_feeds(){
    $xml = $this->xml_tree;
    $channel = $xml->channel;
    $feeds = $this->feeds;
    foreach($channel->item as $item){
        $feed_data = $this->feeds_extra_data;
        $feed_data['title'] = (string)$item->title;
        $feed_data['body'] = strip_tags((string)$item->description);
        $feed_data['link'] = (string)$item->link;
        $feed_data['cover_image_url'] = current($item->enclosure->attributes())['url'];
        $feeds->push($feed_data);
    }
    $this->feeds = $feeds;
    return $this;
  }
}