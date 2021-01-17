<?php

namespace App\Models;

use App\Traits\HasAuthor;
use App\Traits\HasComments;
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
        HasComments,
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
    ];

    public function commentable()
    {
        return $this->morphTo();
    }
}
