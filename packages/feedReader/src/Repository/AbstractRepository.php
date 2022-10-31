<?php
namespace Metft\FeedReader\Repository;
use Illuminate\Database\Eloquent\Model;

  class AbstractRepository {
   protected ?Model $model = null;
   public function __construct(Model $model){
    $this->model = $model;
   }

}