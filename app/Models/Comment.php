<?php

namespace App\Models;

use App\Traits\HasAuthor;
use App\Traits\HasComments;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
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
        Likeable,
        Searchable;

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
        'content_raw',
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
        ];
    }
}
