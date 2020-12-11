<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The tag model
 * 
 * @author admiral-thrawn
 */
class Tag extends Model
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
        // The title of the article
        'title',
        // The content (written in Markdown)
        'content',
        // The author of the article
        'author_id',
        /*
        Whether the article is blocked
        if it is blocked, it can only be seen by the admins
        */
        'blocked',
    ];

    /**
     *
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
