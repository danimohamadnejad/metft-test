<?php
namespace Metft\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Metft\Auth\LoginMethods\LoginMethod;

class AuthGuard implements Guard{
 protected ?UserProvider $provider = null;   
 protected ?Authenticatable $user = null;
 protected ?LoginMethod $login_method = null;

 public function __construct(UserProvider $provider, LoginMethod $login_method){
    $this->provider = $provider;
    $this->login_method = $login_method;
    dd($login_method);
 }
 public function check(){
    return !is_null($this->user);
 }
 public function set_login_method(LoginMethod $login_method){
   $this->login_method = $login_method;
   return $this;
 }
 public function user(){
    return $this->user;
 }
 public function guest(){
    return !$this->check();
 }
 public function id(){
    return $this->check() ? $this->user->getKey() : null;
 }
 public function hasUser(){
    return !is_null($this->user); 
 }
 public function setUser(Authenticatable $user){
    $this->user = $user;
    return $this;
 }
 public function login(){
      
 }
 public function validate(array $credentials = []){

 }
}