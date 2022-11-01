<?php
namespace Metft\Auth\Http\Controllers;
use Metft\Auth\Http\Controllers\ApiController;
use Metft\Auth\Http\Requests\RegisterationRequest;
use Metft\Auth\Http\Requests\AuthenticationRequest;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Hash;

class AuthController extends ApiController{
 public function authenticate(AuthenticationRequest $req, User $umodel){
  $data = $req->validated();
  $user = $umodel->whereEmail($data['email'])->first();
  if(!$user || !Hash::check($data['password'], $user->password)){
    return $this->errorResponse([], 404, 'User not found');
  }  
  $access_token = $user->createToken(Str::random());
  if($access_token){
    return $this->successResponse([
      'token'=>$access_token->plainTextToken,
      'How to use token?'=>"Send token as authorization header -->> Authorization: Bearer {token}"
    ], "User authenticated");
  }
  return $this->errorResponse([], 500, "Could not authenticate. Server error occurred.");
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