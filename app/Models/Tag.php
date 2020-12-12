<?php

namespace App\Models;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 标签模型
 *
 * @author admiral-thrawn
 */
class Tag extends Model
{
    use HasFactory, UseUuid;

    /**
     * 可以修改的字段
     *
     * @var array
     */
    protected $fillable = [
        // 标签名称
        'name',
        /*
        标签是否被封禁
        封禁后仅管理员可见
        */
        'blocked',
    ];

    /**
     * 有此标签的文章
     *
     * @param string relationship article_tag
     * @param string foreign_key tag_id
     * @param string foreign_key article_id
     *
     * @return Article
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_tag', 'tag_id', 'article_id');
    }

    /**
     * 有此标签的帖子
     *
     * @param string relationship post_tag
     * @param string foreign_key tag_id
     * @param string foreign_key post_id
     *
     * @return Article
     */
    public function posts()
    {
        return $this->belongsToMany(Article::class, 'post_tag', 'tag_id', 'post_id');
    }
}
