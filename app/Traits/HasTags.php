<?php

namespace App\Traits;

trait HasTags
{
    /**
     * 标签
     *
     * @param string table_name tags
     *
     * @param string relationship taggable
     * @param string foreign_key tag_id
     *
     * @return Tag
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
