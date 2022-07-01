<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // @TODO implement
        return [
            'isbn' => ['required','string','numeric','unique:books',
                        function ($attribute, $value, $fail) {
                            if (is_string($value) && strlen($value) !== 13) {
                                $fail("The $attribute must be 13 digits.");
                            }
                        },],
            'title' => 'required|string',
            'description' => 'required|string',
            'authors' => 'required|array',
            'authors.*' => 'integer|exists:authors,id',
            'published_year' => 'required|integer|between:1900,2020',
        ];
    }
}
