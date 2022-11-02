<?php
namespace Metft\Auth\LoginMethods;
use Metft\Auth\LoginMethods\LoginMethod;

class LoginWithIdPass extends LoginMethod{
    public const ID_KEYS = ['email',]; 
    public const PASSWORD_KEY = 'password';

    public function login(){    
     if($this->validate_request()){
     }
     return false;
    }
    private function get_id_values(){
      return $this->get_request()->only(static::ID_KEYS);  
    }
    protected function validate_request() : bool{
      $id_values = $this->get_id_values();
      foreach($id_values as $k=>$v){
        if(!empty($v)){
            return true;
        }
      }
      $this->set_error("Your credentials are wrong.");
      return false;
    }

}
