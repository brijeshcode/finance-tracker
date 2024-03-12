<?php

namespace App\Http\Requests\Admin\AdvanceSetups;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('users create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:users|max:255',
            'email' => 'required|unique:users|email',
            'mobile' => 'required|unique:users',
            'password' => 'required|min:4',
            'role' => 'required',
        ];
    }
}
