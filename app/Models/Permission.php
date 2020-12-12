<?php

namespace App\Models;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 权限模型
 * @author admiral-thrawn
 */
class Permission extends Model
{
    use HasFactory, UseUuid, SoftDeletes;

    /**
     * 可以修改的字段
     *
     * @var array
     */
    protected $fillable = [
        // 权限名称
        'name',
        // 介绍
        'decription',
    ];

    /**
     * 有此权限的角色
     *
     * @param string relationship role_permission
     * @param string foreign_key permission_id
     * @param string foreign_key role_id
     *
     * @return Role
     */
    public function roles()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'permission_id', 'role_id');
    }
}
