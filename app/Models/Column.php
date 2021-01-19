<?php

namespace App\Models;

use App\Traits\HasAuthor;
use App\Traits\HasComments;
use App\Traits\HasTags;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelLike\Traits\Likeable;
use Overtrue\LaravelSubscribe\Traits\Subscribable;

/**
 * 专栏模型
 *
 * @author admiral-thrawn
 */
class Column extends Model
{
    use HasFactory,
        Uuids,
        SoftDeletes,
        HasAuthor,
        HasComments,
        HasTags,
        Likeable,
        Favoriteable,
        Subscribable,
        HasTags,
        Searchable;

    public $incrementing = false;

    /**
     * 可以修改的字段
     *
     * @var array
     */
    protected $fillable = [
        // 介绍
        'description',
        'description_raw',
        // 背景板
        'background',
        'cover'
    ];

    protected $hidden = [
        'description_raw'
    ];

    /**
     * 此专栏的文章
     *
     * @return Article articles
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'column_id');
    }

    /**
     * 去除HTML标签
     */
    public function cleanDesc()
    {
        return strip_tags($this->description);
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
            'cleanDesc' => $this->cleanDesc(),
        ];
    }
}
