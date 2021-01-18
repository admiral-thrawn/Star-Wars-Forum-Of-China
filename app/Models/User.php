<?php

namespace App\Models;

use Emadadly\LaravelUuid\Uuids;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use Overtrue\LaravelFavorite\Traits\Favoriter;
use Overtrue\LaravelFollow\Followable;
use Overtrue\LaravelLike\Traits\Liker;
use Overtrue\LaravelSubscribe\Traits\Subscribable;
use Overtrue\LaravelSubscribe\Traits\Subscriber;
use Silber\Bouncer\Database\HasRolesAndAbilities;

/**
 * 用户模型
 * @author admiral-thrawn
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory,
        Notifiable,
        SoftDeletes,
        Uuids,
        HasRolesAndAbilities,
        HasApiTokens,
        Followable,
        Liker,
        Favoriter,
        Subscriber,
        Searchable;

    public $incrementing = false;

    /**
     * 允许修改的字段
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'nickName',
        'email',
        'password',
        'avatar',
        'slogan',
        'description'
    ];

    /**
     * 隐藏的字段
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 用户发布的文章
     *
     * @param string table_name articles
     * @param string foreign_key author_id
     *
     * @return Article
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    /**
     * 用户发布的评论
     *
     * @param string table_name comments
     * @param string foreign_key author_id
     *
     * @return Comment
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'author_id');
    }

    /**
     * 用户发布的帖子
     *
     * @param string table_name posts
     * @param string foreign_key author_id
     *
     * @return Post
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    /**
     * 用户发布的话题
     *
     * @param string table_name topics
     * @param string foreign_key author_id
     *
     * @return Topic
     */
    public function topics()
    {
        return $this->hasMany(Topic::class, 'author_id');
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
            'name' => $this->name,
            'nickName' => $this->nickName,
            'desciption' => $this->description,
        ];
    }
}
