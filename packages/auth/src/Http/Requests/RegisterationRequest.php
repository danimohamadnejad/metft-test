<?php
namespace Metft\Auth\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class RegisterationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'=>['required', 'email', 'max:255', 'unique:users,email'],
            'password'=>['required'],
        ];
    }
}
