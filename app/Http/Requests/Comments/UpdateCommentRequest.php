<?php

namespace App\Http\Requests\Comments;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $comment = Comment::findOrFail($this->route('comment'));
        return Gate::authorize('update', $comment);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => ['required', 'min:1', 'max:600'],
            'content_raw' => ['required', 'min:1', 'max:500'],
            'article_id' => ['required', 'string'],
            'parent_id' => ['nullable', 'string']
        ];
    }
}
