<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelLike\Traits\Likeable;
use Overtrue\LaravelSubscribe\Traits\Subscribable;

/**
 * 话题模型
 * @author admiral-thrawn
 */
class Topic extends Model
{
    use HasFactory,
        Uuids,
        SoftDeletes,
        HasAuthor,
        Subscribable,
        Favoriteable,
        Likeable;

    public $incrementing = false;

    /**
     * 可以修改的字段
     *
     * @var array
     */
    protected $fillable = [
        // 话题名称
        'name',
        // 话题介绍
        'description',
        // 发布者
        'author_id',
    ];

    /**
     * 此话题下的帖子
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
     * 此话题下的文章
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
     * 关注此话题者
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
