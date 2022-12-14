<?php
function feed_reader_tr($key){
    return trans(feed_reader_get_translation_prefix()."${key}");
}
function feed_reader_get_translation_prefix()
{
    return "feedReader::";
}
function feed_reader_get_news_server_active_status_value(){
    return feed_reader_from_config("feed-server-statuses.active.value");
}
function feed_reader_from_config($key){
    $out = config("feedReader.${key}");
    return $out;
}
function feed_reader_get_news_server_status_values(){
    $statuses = feed_reader_from_config("feed-server-statuses");
    $statuses = array_values($statuses);
    $out = array_map(function($st){
        return $st['value'];
    }, $statuses);
    return $out;
}
function feed_reader_get_app_locale_key(){
    return feed_reader_from_config("app.locale-key");
}