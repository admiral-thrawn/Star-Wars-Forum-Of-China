<?php

namespace App\Http\Requests\Posts;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $post = Post::findOrFail($this->route('post'));
        return Gate::authorize('update', $post);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'min:1', 'max:100'],
            'content' => ['required', 'min:5', 'max:700'],
            'content_raw' => ['required', 'min:5' ,'max:600'],
            'parent_id' => ['nullable', 'string'],
            'topic_id' => ['nullable', 'string']
        ];
    }
}
