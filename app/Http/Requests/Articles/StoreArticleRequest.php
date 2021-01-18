<?php

namespace App\Http\Requests\Articles;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
        return [
            'title' => ['required', 'min:1', 'max:45'],
            'description' => ['required', 'min:1', 'max:250'],
            'content' => ['required', 'min:5', 'max:8000'],
            'topic_id' => ['nullable', 'string'],
            'tags' => ['nullable', 'array']
        ];
    }
}
