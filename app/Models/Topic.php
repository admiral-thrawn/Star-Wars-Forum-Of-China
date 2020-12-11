<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The Topic model
 * @author admiral-thrawn
 */
class Topic extends Model
{
    use HasFactory, UsesUuid;

    /**
     * The fillable columns
     *
     * @var array
     */
    protected $fillable = [
        // The name of the tag
        'name',
        // The decription
        'description',
        // The author
        'author_id',
        /*
        Whether the tag is blocked
        if it is blocked, it can only be seen by the admins
        */
        'blocked',
    ];

    /**
     * Find the User who created the Topic
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
     * Find the Posts which belongs to the topic
     *
     * @param string table_name posts
     * @param string foreign_key topic_id
     *
     * @return Post
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'topic_id');
    }

    /**
     * Find the Articles which belongs to the topic
     *
     * @param string table_name articles
     * @param string foreign_key topic_id
     *
     * @return Article
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'topic_id');
    }

    /**
     * Find the users who follow the topic
     *
     * @param string table_name user_follow_topic
     * @param string foreign_key topic_id
     * @param string foreign_key follower_id
     *
     * @return User
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow_topic', 'topic_id', 'follower_id');
    }
}
