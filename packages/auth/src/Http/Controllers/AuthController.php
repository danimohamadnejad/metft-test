<?php
namespace Metft\Auth\Http\Controllers;
use Metft\Auth\Http\Controllers\ApiController;
use Metft\Auth\Http\Requests\RegisterationRequest;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends ApiController{
 
 public function authenticate(Request $req, User $umodel){
  $user = $umodel->first();
  $token = $user->createToken(Str::random());
  return $token->plainTextToken;
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
 
}