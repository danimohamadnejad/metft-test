<?php
namespace Metft\Auth\LoginMethods;
use Illuminate\Http\Request;

abstract class LoginMethod{
 protected ?Request $request = null;
 protected $error = '';
 protected $request_validated = false;
 
 public function __construct(Request $request){
    $this->request = $request;
    $this->error = '';
 }   

 protected function set_request_validated($flag){
   $this->request_validated = $flag;
   return $this;
 }

 protected function set_error($error = ''){
   $this->error = $error;
   return $this;
 }

 public abstract function login();

 protected abstract function validate_request() :bool;

}