<?php
namespace Metft\Auth\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class AuthenticationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'=>['required', 'email'],
            'password'=>['required'],
        ];
    }
}
