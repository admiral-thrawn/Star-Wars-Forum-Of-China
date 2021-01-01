<?php

namespace App\Models;

use App\Traits\HasAuthor;
use App\Traits\HasComments;
use App\Traits\HasTags;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 专栏模型
 *
 * @author admiral-thrawn
 */
class Column extends Model
{
    use HasFactory, Uuids, SoftDeletes, HasAuthor, HasComments, HasTags;

    public $incrementing = false;

    /**
     * 可以修改的字段
     *
     * @var array
     */
    protected $fillable = [
        // 专栏发布者
        'author_id',
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
}
