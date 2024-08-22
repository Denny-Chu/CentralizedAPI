<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cagent extends Model
{
    // 设置模型对应的数据表
    protected $table = 'cagent';

    // 指定自定义主键，不使用 Laravel 的默认主键名 'id'
    protected $primaryKey = 'uid';

    // 开启自动递增
    public $incrementing = true;

    // 如果您不希望使用 Eloquent 的 created_at 和 updated_at 时间戳，可以设置为 false
    public $timestamps = false;

    // 指定可以批量赋值的字段
    protected $fillable = [
        'cagent',
        'parent_uid',
        'cagent_group_game_permission_uid',
        'cagent_group_game_profit_uid',
        'cagent_page_permission_uid',
        'cagent_path',
        'oauth_ts',
        'type',
        'level',
        'src',
        'nick_name',
        'login_name',
        'vpoint',
        'passwd',
        'status',
        'create_time',
        'create_ts',
        'bet_limit',
        'name_set',
        'true_name',
        'mobile',
        'birthday',
        'email',
        'banduid',
    ];

    // 指定应该被隐藏的属性。
    protected $hidden = [
        'passwd'
    ];

    public function singleWalletSet()
    {
        return $this->hasMany(singleWalletSet::class, 'cagent_uid', 'uid');
    }
}
