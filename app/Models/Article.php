<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 文章模型
 *
 * @author admiral-thrawn
 */
class Article extends Model
{
    use HasFactory, UsesUuid;

    /**
     * 可以修改的字段
     *
     * @var array
     */
    protected $fillable = [
        // 文章标题
        'title',
        // 文章简介
        'description',
        // 文章正文内容
        'content',
        // 文章作者
        'author_id',
        // 所属的话题
        'topic_id',
        /*
        文章是否被封禁
        封禁后仅管理员可见
        */
        'blocked',
    ];

    /**
     * 文章作者
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
     * 文章评论
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
     * 文章标签
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
     * 文章所属的话题
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
