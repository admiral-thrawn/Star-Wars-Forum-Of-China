<?php

namespace App\Traits;

trait HasParentAndSub
{
    /**
     * 父级
     *
     * Self-related
     *
     * @param string foreign_key parent_id
     *
     * @return Tag
     */
    public function parent()
    {
        return $this->belongsTo($this->get_class, 'parent_id');
    }

    /**
     * 子级
     *
     * Self-related
     *
     * @param string foreign_key parent_id
     *
     * @return Tag
     */
    public function sub()
    {
        return $this->hasMany($this->get_class, 'parent_id');
    }
}
