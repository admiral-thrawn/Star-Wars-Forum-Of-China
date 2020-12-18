<?php

namespace App\Models;

use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 帖子模型
 *
 * @author admiral-thrawn
 */
class Post extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    public $incrementing = false;

    /**
     * 可以修改的字段
     *
     * @var array
     */
    protected $fillable = [
        // 帖子标题
        'title',
        // 内容
        'content',
        // 发布者
        'author_id',
        // 回复的帖子
        'parent_id',
        // 话题
        'topic_id',
    ];

    /**
     * 帖子作者
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
     * 标签
     *
     * @param string table_name tags
     *
     * @param string relationship taggable
     * @param string foreign_key post_id
     * @param string foreign_key tag_id
     *
     * @return Tag
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * 父级帖子
     *
     * Self-related
     *
     * @param string table_name tags (Self-related)
     * @param string foreign_key parent_id
     *
     * @return Tag
     */
    public function parentPost()
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }

    /**
     * 子级帖子
     *
     * Self-related
     *
     * @param string table_name tags (Self-related)
     * @param string foreign_key parent_id
     *
     * @return Tag
     */
    public function subPosts()
    {
        return $this->hasMany(Post::class, 'parent_id');
    }

    /**
     * 话题
     *
     * @param string table_name topics
     * @param string foreign_key topic_id
     *
     * @return User
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }
}
