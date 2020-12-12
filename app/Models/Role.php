<?php

namespace App\Models;

use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 角色模型
 * @author admiral-thrawn
 */
class Role extends Model
{
    use HasFactory, SoftDeletes, Uuids;

    public $incrementing = false;

    /**
     * 可以修改的字段
     *
     * @var array
     */
    protected $fillable = [
        // 角色名称
        'name',
        // 角色代码
        'code',
        // 介绍
        'description',
    ];

    /**
     * 有此角色的用户
     *
     * @param string relationship user_role
     * @param string foreign_key role_id
     * @param string foreign_key user_id
     *
     * @return User
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id');
    }
}
