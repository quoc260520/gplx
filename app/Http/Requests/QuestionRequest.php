<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class QuestionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'kind' => 'bail|required|exists:kind_questions,id',
            'question' => 'bail|required|string|min:50',
            'is_paralysis' => 'bail|nullable|in:0,1',
            'image' => 'bail|nullable|image|max:10000|mimes:jpeg,png,jpg',
            'note' => 'bail|nullable|string|min:10',
            'answers' => 'required|array|min:2|max:4',
            'answers.*' => 'required|string',
            'is_correct' => 'required|array',
            'is_correct.*' => 'required|in_array:[1,2,3,4]',
        ];
    }
}
