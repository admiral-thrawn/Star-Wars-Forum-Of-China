<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasAuthor
{

    public static function bootHasAuthor()
    {
        static::saving(function ($model) {
            $model->author_id = $model->author_id ?? Auth::id();
        });
    }

    /**
     * 作者
     *
     * @param string table_name users
     * @param string foreign_key author_id
     *
     * @return User
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
