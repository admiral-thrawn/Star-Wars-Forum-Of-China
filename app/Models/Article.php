<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The article model
 *
 * @author admiral-thrawn
 */
class Article extends Model
{
    use HasFactory;

    /**
     * Disable primary key auto-increment
     * @var boolean
     */
    public $incrementing = false;

    /**
     * The fillable columns
     *
     * @var array
     */
    protected $fillable = [
        // The title of the article
        'title',
        // The content (written in Markdown)
        'content',
        // The author of the article
        'author_id',
        // The topic of the article
        'topic_id',
        /*
        Whether the article is blocked
        if it is blocked, it can only be seen by the admins
        */
        'blocked',
    ];

    /**
     * Find the author of the article
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

    /**
     * Find the comments of the article
     *
     * @param string table_name comments
     * @param string foreign_key article_id
     *
     * @return Comment
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id');
    }

    /**
     * Find the tags of the article
     *
     * @param string table_name tags
     *
     * @param string relationship article_tag
     * @param string foreign_key article_id
     * @param string foreign_key tag_id
     *
     * @return Tag
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag', 'article_id', 'tag_id');
    }

    /**
     * Find the topic of the article
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
