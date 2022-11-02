<?php
namespace Metft\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class AuthGuard implements Guard{
 protected ?UserProvider $provider = null;   
 protected ?Authenticatable $user = null;
 
 public function __construct(UserProvider $provider){
    $this->provider = $provider;
 }
 public function check(){
 }
 public function user(){
 }
 public function guest(){

 }
 public function id(){

 }
 public function hasUser(){

 }
 public function setUser(Authenticatable $user){
    $this->user = $user;
 }
 public function validate(array $credentials = []){

 }
}