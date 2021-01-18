<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasAuthor
{
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
