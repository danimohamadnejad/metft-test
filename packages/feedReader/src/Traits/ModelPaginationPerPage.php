<?php
namespace Metft\FeedReader\Traits;
trait ModelPaginationPerPage{
    public function get_per_page(){
        return config("feedReader.per-page");
    }
}