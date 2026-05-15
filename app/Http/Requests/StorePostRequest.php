<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [ 'required' ,'string', 'min:3', 'max:255', 'unique:posts,title'],
            'content' => 'required|string|min:10',
            'author_id'=> 'required|exists:users,id',
            'image' => 'required|image',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please enter a title',
            'title.string' => 'Title must be a string',
            'title.min' => 'Title must be at least 3 characters',
            'title.max' => 'Title must be at most 255 characters',
            'title.unique' => 'This title already exists',
            'content.required' => 'Please enter the content',
            'content.string' => 'Content must be a string',
            'content.min' => 'Content must be at least 10 characters',
            'author_id.required' => 'Please select an author',
            'author_id.exists' => 'Author not found',
            'image.required' => 'Please upload an image',
            'image.image' => 'The file must be an image',
        ];
    }
}
