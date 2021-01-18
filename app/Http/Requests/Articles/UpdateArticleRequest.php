<?php

namespace App\Http\Requests\Articles;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        $article = Article::findOrFail($this->route('article'));

        return Gate::authorize('update', $article);;
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
