<?php

namespace App\Traits;

trait HasTopic
{
    /**
     * 所属的话题
     *
     * @param string table_name topics
     * @param string foreign_key topic_id
     *
     * @return Topic
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }
}
