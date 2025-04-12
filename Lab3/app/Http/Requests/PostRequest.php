<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
        $rules = [
            'title' => [
                'required',
                'min:3',
                Rule::unique('posts')->ignore($this->post)
            ],
            'content' => 'required|min:10',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpg,png|max:2048',
        ];

        return $rules;
    }
}
