<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class UserAdminRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'             => ['required', 'string'],
            'ends_at'          => ['nullable', 'date'],
            'status'           => [Rule::in([0, 1])],
            'email'            => ['nullable', 'string', 'email', Rule::unique('users')->ignore($this->user->id ?? '')],
            'password'         => [Rule::excludeIf(!empty($this->user->id) && !request()->password), 'required', 'string'],
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Введите Имя',
            'email.email' => 'Введите корректный E-mail',
            'email.unique' => 'Такой E-mail уже занят',
            'password.required' => 'Введите пароль',
        ];
    }

}
