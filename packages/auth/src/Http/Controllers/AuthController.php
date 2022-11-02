<?php
namespace Metft\Auth\Http\Controllers;
use Metft\Auth\Http\Controllers\ApiController;
use Metft\Auth\Http\Requests\RegisterationRequest;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Hash;

class AuthController extends ApiController{
 public function login(Request $req, User $umodel){
  $res = Auth::login();
 }

 public function register(RegisterationRequest $req, User $umodel){
  $user = $umodel->create($req->validated());  
  if($user){
    return $this->successResponse([
        'user'=>UserResource::make($user),
    ], "Registration successfuly done");
  }
  return $this->errorResponse([], 500, "Registration failed");
 }
 
 public function logout(Request $req){  
    $req->user()->tokens()->delete();
    $req->user()->currentAccessToken()->delete();
    return $this->successResponse([], "User logged out");
 }
 
}