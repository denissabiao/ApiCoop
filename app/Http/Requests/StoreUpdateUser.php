<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class StoreUpdateUser extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */

    public function rules(): array
    {
        return [
            'cpf' => 'required|unique:users,cpf',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'data_nascimento' => 'required|date',
            'telefone' => 'required',
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'Cpf.required' => 'Cpf é um campo obrigatório.',
            'email.required' => 'Email é um campo obrigatório.',
            'password.required' => 'Senha é um campo obrigatório.',
            'data_nascimento.required' => 'Data Nascimento é um campo obrigatório.',
            'telefone.required' => 'Telefone é um campo obrigatório.',
            'name.required' => 'Nome é um campo obrigatório.'
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => 'Erro de validação',
            'messages' => $validator->errors()
        ], 400));
    }


}