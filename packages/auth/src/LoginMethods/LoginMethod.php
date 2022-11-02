<?php
namespace Metft\Auth\LoginMethods;
use Illuminate\Http\Request;
use App\Models\User;

abstract class LoginMethod{
 protected ?Request $request = null;
 protected $error = '';
 protected ?User $model = null;

 public function __construct(Request $request, User $model){
    $this->request = $request;
    $this->model = $model;
    $this->error = '';
 }   
 public function get_request(){
  return $this->request;
 }
 public function get_model(){
  return $this->model;
 }
 protected function set_error($error = ''){
   $this->error = $error;
   return $this;
 }

 public abstract function login();
 protected abstract function retrieve_user();
 protected abstract function validate_request() :bool;

}