<?php

namespace App\Models;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 通知模型
 *
 * @author admiral-thrawn
 */
class Notification extends Model
{
    use HasFactory, UseUuid, SoftDeletes;

    /**
     * 可以修改的字段
     *
     * @var array
     */
    protected $fillable = [
        // 通知标题
        'title',
        //通知内容
        'content',
    ];

    /**
     * 查找目标用户
     *
     * @param string relationship notification_user
     * @param string foreign_key notification_id
     * @param string foreign_key user_id
     *
     * @return User
     */
    public function targets()
    {
        return $this->belongsToMany(User::class, 'notification_user', 'notification_id', 'user_id');
    }
}
