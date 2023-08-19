<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // TODO - False é o padrão pra verificar se o usuario pode ou nao fazer a ação
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|min:3|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users'
            ],
            'password' => [
                'required',
                'min:6',
                'max:100',
            ],
        ];

        //TODO - mover pra um request proprio
        if ($this->method() === 'PATCH') {
            $rules['email'] = [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->id),
            ];

            $rules['password'] = [
                'nullable',
                'min:6',
                'max:100',
            ];
        }

        return $rules;
    }
}
