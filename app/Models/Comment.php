<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 评论模型
 *
 * @author admiral-thrawn
 */
class Comment extends Model
{
    use HasFactory, UsesUuid;

    /**
     * 可以修改的字段
     *
     * @var array
     */
    protected $fillable = [
        // 评论发布者
        'author_id',
        // 评论内容
        'content',
        /*
        是否被封禁
        如果被封禁，只有管理员可见
        如果此评论所属文章被封禁，此评论被封禁
        */
        'blocked',
        // 所属的文章
        'article_id',
        // 父级评论的id
        'parent_id',
    ];

    /**
     * 所属文章
     *
     * @param string table_name articles
     * @param string foreign_key article_id
     *
     * @return Article
     */
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    /**
     * 评论发布者
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
     * 子评论
     *
     * @param string table_name comments
     * @param string foreign_key parent_id
     *
     * @return Comment
     */
    public function subComments()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
