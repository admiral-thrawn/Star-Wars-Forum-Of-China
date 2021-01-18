<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = User::findOrFail($this->route('user'));

        return Gate::authorize('update', $user);;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['nullable','max:20'],
            'description' => ['nullable','max:200'],
            'slogan' => ['nullable','max:40'],
            'description_raw' => ['nullable', 'max:180'],
            'background' => ['nullable']
        ];
    }
}
