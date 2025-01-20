<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response as Resp;
use Illuminate\Validation\Rule;

class UserPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'password_confirmation' => 'required|string|min:8|same:password',
            ];
        } elseif ($this->isMethod('put')) {
            if(!$this->user()){
                throw new HttpResponseException(response()->notFound('user not found'));
            }
            return [
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users','email')->ignore($this->user()->id),
                ],
                'password' => 'required|string|min:8',
                'password_confirmation' => 'required|string|min:8|same:password',
            ];
        }
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'data'=> $validator->errors(),
                'status'=>Resp::$statusTexts[400],
                'code'=>Resp::HTTP_BAD_REQUEST],400)
        );
    }
}
