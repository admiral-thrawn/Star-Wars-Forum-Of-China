<?php

namespace App\Models;

use App\Traits\HasAuthor;
use App\Traits\HasParentAndSub;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Overtrue\LaravelLike\Traits\Likeable;

/**
 * 评论模型
 *
 * @author admiral-thrawn
 */
class Comment extends Model
{
    use HasFactory,
        Uuids,
        SoftDeletes,
        HasAuthor,
        HasParentAndSub,
        Likeable;

    public $incrementing = false;

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
        // 所属的文章
        'article_id',
        // 父级评论的id
        'parent_id',
    ];

    public function commentable()
    {
        return $this->morphTo();
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
