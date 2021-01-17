<?php

namespace App\Models;

use App\Traits\HasAuthor;
use App\Traits\HasComments;
use App\Traits\HasTags;
use App\Traits\HasTopic;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelLike\Traits\Likeable;
use Overtrue\LaravelSubscribe\Traits\Subscribable;

/**
 * 文章模型
 *
 * @author admiral-thrawn
 */
class Article extends Model
{
    use HasFactory,
        Uuids,
        SoftDeletes,
        HasComments,
        HasTags,
        HasTopic,
        HasAuthor,
        Likeable,
        Favoriteable,
        Subscribable,
        HasTags;

    public $incrementing = false;

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
    ];
}
