<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The comment model
 *
 * @author admiral-thrawn
 */
class Comment extends Model
{
    use HasFactory;


    /**
     * Disable primary key auto-increment
     * @var boolean
     */
    public $incrementing = false;

    /**
     * The fillable columns
     *
     * @var array
     */
    protected $fillable = [
        // The author of the article
        'author_id',
        // The content (written in Markdown)
        'content',
        /*
        Whether the comment is blocked
        if it is blocked, it can only be seen by the admins
        if the article which the comment belongs to is blocked, the comment will be blocked
        */
        'blocked',
        // The article which the comment belongs to
        'article_id',
    ];

    /**
     * Find the article which the comment belongs to
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
     * Find the author of the comment
     * @param string table_name users
     * @param string foreign_key author_id
     *
     * @return User
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
